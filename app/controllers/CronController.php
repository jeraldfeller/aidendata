<?php

namespace Aiden\Controllers;

class CronController extends _BaseController {

    public function processPdfQueueAction() {

        self::processPdfQueue();
        $this->response->redirect();

    }

        public function analysePdfsAction() {

        self::analysePdfs();
//        $this->response->redirect();

    }

    public function scrapeSourcesAction() {

        $this->dispatcher->forward(['controller' => 'scrape', 'action' => 'index']);

    }

    public function emailMatchesAction() {
        self::emailMatches();
      //  $this->response->redirect();
    }

    /**
     * Takes all unprocessed `matches` and generates a page that we'll later file_get_contents
     * so we can send it to users by email
     */
    public function generateDigestAction() {

        set_time_limit(3600);
        $di = \Phalcon\DI::getDefault();

        // Retrieve all ScrapeSources that have unprocessed matches
        $phql = "SELECT [Aiden\Models\ScrapeSources].*"
                . " FROM [Aiden\Models\ScrapeSources]"
                . " INNER JOIN [Aiden\Models\Pdfs]"
                . " ON [Aiden\Models\Pdfs].scrape_sources_id = [Aiden\Models\ScrapeSources].id"
                . " INNER JOIN [Aiden\Models\Matches]"
                . " ON [Aiden\Models\Matches].pdf_id = [Aiden\Models\Pdfs].id"
                . " WHERE 1=1"
                . " AND [Aiden\Models\Matches].processed = 0"
                . " GROUP BY [Aiden\Models\ScrapeSources].id";

        $scrapeSources = $this->modelsManager->executeQuery($phql);

        $this->view->setVars([
            'scrapeSources' => $scrapeSources,
        ]);

        $this->view->pick('_emails/matches');

    }

    /**
     * Checks downloaded PDFs for keywords
     */
    public static function analysePdfs() {


        $di = \Phalcon\DI::getDefault();
        $config = $di->getConfig();
        $logger = $di->getLogger();
        $unanalysedPdfs = \Aiden\Models\Pdfs::find(
            [
                'conditions' => 'last_checked IS NULL LIMIT 1'
            ]
        );
                foreach ($unanalysedPdfs as $unanalysedPdf) {
                    echo $unanalysedPdf->id . '<br>';
            // Get PDF output
            $output = \Aiden\Classes\SwissKnife::getOutput($unanalysedPdf->url);
            if ($output === false) {

                $message = sprintf('Could not get output from [%s]', $unanalysedPdf->url);
                $logger->warning($message);
                continue;
            }

            // Checksum the PDF output and see if it already exists in the database.
            $pdfChecksum = md5($output);

            $unanalysedPdf->checksum = $pdfChecksum;
            if ($unanalysedPdf->save()) {

                $message = sprintf('Set checksum for PDF [%s] to [%s]', $unanalysedPdf->id, $pdfChecksum);
                $logger->debug($message);
            }
            else {

                $message = sprintf('Could not set checksum for PDF from [%s] (%s)'
                        , $unanalysedPdf->url, print_r($unanalysedPdf->getMessages(), true));
                $logger->debug($message);
                continue;
            }

            try
            {

                var_dump('try');
                // Try to parse the PDF. Might need to find another way for huge PDFs (100MB+)
                $pdfParser = new \Smalot\PdfParser\Parser();

                $pdfObject = $pdfParser->parseContent($output);

                $pages = $pdfObject->getPages();
                var_dump(count($pages));

                self::checkPages($unanalysedPdf, $pages);
                $unanalysedPdf->last_checked = date("Y-m-d H:i:s");
                if($unanalysedPdf->save()){
                    echo 'SAVED <BR>';
                }else{
                    var_dump($unanalysedPdf->getMessages());
                }
            }
            catch (\Exception $e)
            {
                // If PDF is secured, try to unsecure it using ghostscript
                if ($e->getMessage() === 'Secured pdf file are currently not supported.') {

                    try
                    {

                        $tempInputFilePath = tempnam('/tmp', 'secpdf-input');
                        $tempOutputFilePath = tempnam('/tmp', 'secpdf-output');

                        if ($tempInputFilePath && $tempOutputFilePath) {

                            $handle = fopen($tempInputFilePath, 'w');
                            fwrite($handle, $output);

                            while (is_resource($handle)) {
                                fclose($handle);
                            }

                            // Unlock PDF permissions with Ghostscript
                            $command = sprintf('gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=%s -c .setpdfwrite -f %s'
                                    , $tempOutputFilePath, $tempInputFilePath);
                            exec($command);

                            if (!file_exists($tempOutputFilePath)) {

                                $message = sprintf('Could not remove security from PDF [%s]', $unanalysedPdf->url);
                                $logger->warning($message);
                            }
                            else {

                                $pdfParser = new \Smalot\PdfParser\Parser();
                                $pdfObject = $pdfParser->parseFile($tempOutputFilePath);
                                $pages = $pdfObject->getPages();
                                self::checkPages($unanalysedPdf, $pages);
                                $unanalysedPdf->last_checked = date("Y-m-d H:i:s");
                                $unanalysedPdf->save();
                            }
                        }
                        else {

                            $message = sprintf('Could not remove security from PDF [%s] as input and/or output file could not be generated'
                                    , $unanalysedPdf->url);
                            throw \Exception($message);
                        }
                    }
                    catch (\Exception $ex)
                    {

                        $message = sprintf('PDF [%s] threw an error (%s) (I)', $unanalysedPdf->url, $ex->getMessage());
                        $logger->warning($message);
                    }
                    finally
                    {

                        unlink($tempInputFilePath);
                        unlink($tempOutputFilePath);
                    }
                }
                else {

                    $message = sprintf('PDF [%s] threw an error (%s) (O)', $unanalysedPdf->url, $e->getMessage());
                    $logger->warning($message);
                }
            }
            finally
            {

                $pdfParser = null;
            }

        }

    }

    public static function checkPages(\Aiden\Models\Pdfs $unanalysedPdf, $pages) {

        $di = \Phalcon\DI::getDefault();
        $config = $di->getConfig();
        $logger = $di->getLogger();

        // Loop through all of the pages, and check if one of the phrases is detected
        for ($i = 1; $i < count($pages); $i++) {

            $pageTextArray = $pages[$i]->getTextArray();
            $phrases = \Aiden\Models\Phrases::find();

            // Check each sentence individually
            for ($j = 0; $j < count($pageTextArray); $j++) {

                $currentText = $pageTextArray[$j];

                $updateProcessed = true;
                // Check each sentence against phrases in the database
                foreach ($phrases as $phrase) {

                    // Transform text if case (in)sensitive
                    $checkAgainstText = ($phrase->case_sensitive ? $currentText : strtolower($currentText));
                    $checkAgainstPhrase = ($phrase->case_sensitive ? $phrase->text : strtolower($phrase->text));

                    // Check if text contains phrase
                    if (strpos($checkAgainstText, $checkAgainstPhrase) !== false) {

                        /**
                         * Attempt to generate excerpt by finding the 2 most outer empty elements
                         * Say we're looking for "accusantium", the 2 outer most empty elements are
                         * [1] and [5], so everything between those elements is considered an excerpt
                         * 
                         * [0] Lorem ipsum doler sit amet
                         * [1]
                         * [2] Sed ut perspiciatis unde omnis iste natus error sit
                         * [3] voluptatem accusantium doloremque laudantium
                         * [4] totam rem aperiam, eaque ipsa 
                         * [5]
                         * [6] Other excerpt
                         */
                        $excerptStartIndex = $j;
                        while (isset($pageTextArray[$excerptStartIndex - 1])) {

                            $excerptStartIndex--;
                            $trimmedString = preg_replace('/[a-z]/i', '', $pageTextArray[$excerptStartIndex]);
                            if (strlen($trimmedString) === 0 || $excerptStartIndex + 4 < $j) {
                                break;
                            }
                        }

                        $excerptEndIndex = $j;
                        while (isset($pageTextArray[$excerptEndIndex + 1])) {

                            $excerptEndIndex++;
                            $trimmedString = preg_replace('/[a-z]/i', '', $pageTextArray[$excerptEndIndex]);
                            if (strlen($trimmedString) === 0 || $excerptEndIndex - 4 > $j) {
                                break;
                            }
                        }

                        // Rebuild an excerpt as a single string so we can later send it via email
                        $excerpt = '';
                        for ($k = $excerptStartIndex; $k < $excerptEndIndex; $k++) {
                            $excerpt .= $pageTextArray[$k];
                        }
                        $excerpt = trim($excerpt);

                        // Check if this match somehow magically already exists
                        $existingMatch = \Aiden\Models\Matches::findFirst([
                                    'conditions' => 'pdf_id = :pdf_id: AND phrase_id = :phrase_id: AND excerpt = :excerpt: AND page = :page:',
                                    'bind' => [
                                        'pdf_id' => $unanalysedPdf->id,
                                        'phrase_id' => $phrase->id,
                                        'page' => $i,
                                        'excerpt' => $excerpt
                                    ]
                        ]);
                        if ($existingMatch) {

                            continue;
                        }

                        // Create new Match
                        $match = new \Aiden\Models\Matches();
                        $match->pdf_id = $unanalysedPdf->id;
                        $match->phrase_id = $phrase->id;
                        $match->excerpt = $excerpt;
                        $match->page = $i;
                        $match->processed = 0;

                        if ($match->save()) {

                            $message = sprintf('Found match in [%s] with phrase [%s]. Added to queue.', $unanalysedPdf->url, $phrase->text);
                            $logger->info($message);

                            // Carry on after a paragraph when we already know it contains a phrase
                            $j = $excerptEndIndex;
                        }

                        // Couldn't save Match, model error
                        else {

                            $message = sprintf('Could not save match for [%s] with phrase [%s]. (%s)'
                                    , $unanalysedPdf->url, $phrase->text, print_r($match->getMessages()), true);
                            $logger->error($message);

                            continue;
                        }
                    }
                }

                // Set PDF to being processed.
                $unanalysedPdf->processed = 1;
                $unanalysedPdf->save();
            }
        }

    }

    /**
     * Loops through the `matches` table and generates a single email with
     * matched phrases in unprocessed PDFs
     */
    public static function emailMatches() {

        set_time_limit(3600);
        $di = \Phalcon\DI::getDefault();

        $matches = \Aiden\Models\Matches::find('processed = 0');
        if ($matches->count() === 0) {
            return true;
        }

        // Retrieve all ScrapeSources that have unprocessed matches
        $phql = "SELECT [Aiden\Models\ScrapeSources].*"
                . " FROM [Aiden\Models\ScrapeSources]"
                . " INNER JOIN [Aiden\Models\Pdfs]"
                . " ON [Aiden\Models\Pdfs].scrape_sources_id = [Aiden\Models\ScrapeSources].id"
                . " INNER JOIN [Aiden\Models\Matches]"
                . " ON [Aiden\Models\Matches].pdf_id = [Aiden\Models\Pdfs].id"
                . " WHERE 1=1"
                . " AND [Aiden\Models\Matches].processed = 0"
                . " GROUP BY [Aiden\Models\ScrapeSources].id";

        $scrapeSources = $di->getModelsManager()->executeQuery($phql);
        $totalPdfs = [];

       // $matches = [];
        $totalMatches = 0;
        $totalPhrases = 0;
        $totalPdfs = 0;

        foreach ($scrapeSources as $scrapeSource) {

            $existingMatchesIds = [];
            $existingMatches = []; // We only want to output matches once.

            foreach ($scrapeSource->Pdfs as $pdf) {

                // Tally only if PDF has related matches
                if ($pdf->Matches->count() > 0) {
                    $totalPdfs++;
                }

                foreach ($pdf->Matches as $match) {

                    if (in_array($match->id, $existingMatchesIds)) {
                        continue;
                    }

                    $existingMatchesIds[] = $match->id;
                    $existingMatches[] = $match;
                    $totalMatches++;
                }
            }
        }

        $view = $di->getView();
        $view->start();
        $view->setVars([
            'scrapeSources' => $scrapeSources,
            'totalPdfs' => $totalPdfs,
            'phrases' => count($existingMatches),
            'totalSources' => count($scrapeSources),
        ]);
        $view->setTemplateAfter('_emails/matches'); // template name
        $view->render('controller', 'action');
        $view->finish();

        $emailHtml = $view->getContent();
        $di = \Phalcon\DI::getDefault();
        $config = $di->getConfig();
        $logger = $di->getLogger();

        $postFields = [
            'from' => sprintf('%s <%s>', $config->application->mailFromName, $config->application->mailFromEmail),
            'subject' => $config->application->mailDigestSubject,
            'html' => $emailHtml,
            'text' => strip_tags(\Aiden\Classes\SwissKnife::br2nl($emailHtml)),
        ];

        // Email to all admins
        $users = \Aiden\Models\Users::find('level = ' . \Aiden\Models\Users::LEVEL_ADMINISTRATOR);
        if (count($users) > 1) {

            $to = '';
            foreach ($users as $user) {
                if($user->email == 'jeraldfeller@gmail.com'){
                    echo $user->email . '<br>';
                    $to .= $user->email . ',';
                }
            }
            $to = rtrim($to, ',');
            $postFields['to'] = $to;
        }
        else {

            $postFields['to'] = $users[0]->email;
        }

        var_dump($postFields);
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $config->application->mailgunApiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/' . $config->application->mailgunDomain . '/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !$config->application->dev);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, !$config->application->dev);

        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        // Error
        if ($info['http_code'] != 200) {

            $message = sprintf('Could not send email, HTTP STATUS [%s]', $info['http_code']);
            $logger->error($message);
            return false;
        }

        // Attempt to parse JSON
        $json = json_decode($output);
        if ($json === null) {

            $message = 'Mailgun returned a non-Json response';
            $logger->error($message);
            return false;
        }

        // After we've received confirmation from Mailgun, set matches as 
        // processed so we only get fresh matches next time.
        if ($json->message == 'Queued. Thank you.') {
            foreach ($matches as $match) {
                $match->processed = 1;
                $match->save();
            }
        }
        else {

            $message = print_r($json);
            $logger->error($message);
        }


        */
    }

}
