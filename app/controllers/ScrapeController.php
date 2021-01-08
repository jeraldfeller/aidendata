<?php

namespace Aiden\Controllers;

class ScrapeController extends _BaseController
{

    public function indexAction()
    {

        $sql = 'SELECT * FROM `scrape_urls`'
                . ' WHERE TIMESTAMPDIFF(HOUR, `last_crawl`, CURRENT_TIMESTAMP) > '
                . $this->config->application->scrapeSourcesHourDifference
                . ' OR last_crawl IS NULL'
                . ' LIMIT ' . $this->config->application->amountOfUrlsPerScrape;

        $sql = 'SELECT * FROM `scrape_urls`'
            . ' WHERE scrape_sources_id = 53';


        $scrapeUrl = new \Aiden\Models\ScrapeUrls();
        $scrapeUrls = new \Phalcon\Mvc\Model\Resultset\Simple(null, $scrapeUrl, $scrapeUrl->getReadConnection()->query($sql));

        var_dump($scrapeUrls);
        foreach ($scrapeUrls as $scrapeUrl) {
                if ($scrapeUrl->ScrapeSource->name == 'Blacktown') {
                    $this->scrapeUrlBlacktown($scrapeUrl);
                } else {
                    $this->scrapeUrl($scrapeUrl);
                }
        }

        //  return $this->response->redirect('sources', false, 302);

    }

    public function scrapeUrlByIdAction()
    {

        if (!$this->request->hasQuery('id')) {
            $this->flashSession->error('Invalid request');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $scrapeUrl = \Aiden\Models\ScrapeUrls::findFirstById($this->request->getQuery('id'));
        if (!$scrapeUrl) {
            $this->flashSession->error('Could not find scraping source');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $this->scrapeUrl($scrapeUrl);

        return $this->response->redirect('sources', false, 302);

    }

    public function scrapeUrl(\Aiden\Models\ScrapeUrls $scrapeUrl)
    {

        $message = sprintf('Scraping [%s]. Max depth = [%s]...', $scrapeUrl->scrape_url, $scrapeUrl->depth_level);
//        $this->logger->info($message);
        echo $message . '<br>';
        $adjacentUrls = []; // URLs adjacent to the current page being scraped.
        $scrapedUrls = []; // URLs that have been scraped before, some URLs are located on several pages
        $pdfUrls = []; // URLs pointing to PDF files
        $currentDepth = 0;
        $startTime = microtime(true);

        // Check initial $scrapeUrl->scrape_url
        if ((bool)$scrapeUrl->is_post === true) {

            // Check if we should add post params
            if (strlen($scrapeUrl->post_params) > 0) {

                parse_str($scrapeUrl->post_params, $postParams);

                if ((bool)$scrapeUrl->form_urlencoded === true) {
                    $postParams = http_build_query($postParams);
                }

                $output = \Aiden\Classes\SwissKnife::getOutput($scrapeUrl->scrape_url, true, $postParams);
            } else {

                $output = \Aiden\Classes\SwissKnife::getOutput($scrapeUrl->scrape_url, true, []);
            }

            $formType = (bool)$scrapeUrl->form_urlencoded ? 'application/x-www-form-urlencoded' : 'multipart/form-data';
            $message = sprintf('> Sending [%s] POST request to [%s] with query [%s]'
                , $formType, $scrapeUrl->scrape_url, $scrapeUrl->post_params);
            $this->logger->info($message);
        } else {

            $output = \Aiden\Classes\SwissKnife::getOutput($scrapeUrl->scrape_url);

            $message = sprintf('> Sending GET request to [%s]...', $scrapeUrl->scrape_url);
            $this->logger->info($message);
        }

        // Get all the URLs from the first page
        $urlsOnFirstPage = $this->getAllUrlsOnPageByContent($output, $scrapeUrl);


        foreach ($urlsOnFirstPage as $urlOnFirstPage) {

            // If URL is pointing to a PDF, add to array which will later save the PDF to the database
            if (preg_match($scrapeUrl->regex_pattern, $urlOnFirstPage)) {
                $pdfUrls[] = $urlOnFirstPage;
            } // Else queue the URL for scraping.
            else {
                if (!in_array($urlOnFirstPage, $scrapedUrls) && !in_array($urlOnFirstPage, $adjacentUrls)) {
                    $adjacentUrls[] = $urlOnFirstPage;
                }
            }
        }
        $scrapedUrls[] = $scrapeUrl->scrape_url;
        // Keep following links until we've reached max depth, if a scrapeUrl has 0 depth, it will skip this entire loop.
        while ($currentDepth < $scrapeUrl->depth_level) {

            // Log
            $message = sprintf('> Diving to depth level [%s]...', $currentDepth + 1);
            echo $message . '<br>';
            $this->logger->info($message);

            // Move adjacent URLs to queue array (this is so we can limit the amount of requests)
            $queuedUrls = $adjacentUrls;

            // Empty the adjacent URLs array so we can add fresh ones.
            $adjacentUrls = [];

            // Limit the amount of requests by slicing and splicing the queued URL until empty
            if($scrapeUrl->scrape_sources_id == 29){
                $queuedUrls = array_splice($scrapedUrls, 200);
            }
            while (count($queuedUrls) > 0) {

                $itemsToSliceAndSplice = min([count($queuedUrls), $this->config->application->maxConcurrentRequests]); // Limit concurrent requests
                $urlsToScrape = array_slice($queuedUrls, 0, $itemsToSliceAndSplice); // Copy the elements to one array
                array_splice($queuedUrls, 0, $itemsToSliceAndSplice); // Remove the elements from the queue array

                $urls = [];
                foreach ($urlsToScrape as $urlToScrape) {

                    // Only add non-scraped URLs
                    if (!in_array($urlToScrape, $scrapedUrls)) {
                        $urls[$urlToScrape]['scrapeUrl'] = $scrapeUrl;
                    }
                }

                // Get content async
                $urls = self::getContentFromMultipleUrlsAsync($urls);

                foreach ($urls as $url => $properties) {

                    if ($properties['curl_info']['http_code'] != 200) {

                        $message = sprintf('> [%s] returned status [%s]...', $url, $properties['curl_info']['http_code']);
                        echo $message . '<br>';
                        $this->logger->error($message);

                        continue;
                    }

                    $message = sprintf('> Processing [%s]...', $url);
                    $this->logger->info($message);

                    // Retrieve all URLs from the $urlToScrape, we pass $scrapeUrl so we can
                    // create absolute URLs for websites that only show relative ones.
                    $urlsOnPage = $this->getAllUrlsOnPageByContent($properties['content'], $properties['scrapeUrl']);

                    $message = sprintf('> Found [%s] URLs on [%s]...', count($urlsOnPage), $url);
                    echo $message . '<br>';
                    //$this->logger->info($message);

                    foreach ($urlsOnPage as $urlOnPage) {

                        // If URL is pointing to a PDF, add to array which will later save the PDF to the database
                        if (preg_match($properties['scrapeUrl']->regex_pattern, $urlOnPage)) {

                            $pdfUrls[] = $urlOnPage;
                        } // Else queue the URL for scraping.
                        else {

                            if (!in_array($urlOnPage, $scrapedUrls) && !in_array($urlOnPage, $adjacentUrls)) {
                                $adjacentUrls[] = $urlOnPage;
                            }
                        }
                    }

                    $scrapedUrls[] = $url;
                }
            }
            $currentDepth++;
        }


        $endTime = microtime(true);
        $executionSeconds = ceil(($endTime - $startTime) / 60);

        $this->addPdfUrls($pdfUrls, $scrapeUrl->ScrapeSource);

        $scrapeUrl->last_crawl = date('Y-m-d H:i:s');
        if ($scrapeUrl->save()) {

            $message = sprintf('> Finished scraping [%s] successfully in [%s] seconds. Found [%s] PDF URLs.', $scrapeUrl->scrape_url, $executionSeconds, count($pdfUrls));
            $this->logger->info($message);
        } else {

            $message = sprintf('> Finished scraping [%s] with errors in [%s] seconds. Found [%s] PDF URLs.', $scrapeUrl->scrape_url, $executionSeconds, count($pdfUrls));
            $this->logger->info($message);
        }

    }

    public function scrapeUrlBlacktown(\Aiden\Models\ScrapeUrls $scrapeUrl)
    {

        $message = sprintf('Scraping [%s]. Max depth = [%s]...', $scrapeUrl->scrape_url, $scrapeUrl->depth_level);
//        $this->logger->info($message);
        echo $message . '<br>';
        $adjacentUrls = []; // URLs adjacent to the current page being scraped.
        $scrapedUrls = []; // URLs that have been scraped before, some URLs are located on several pages
        $pdfUrls = []; // URLs pointing to PDF files
        $currentDepth = 0;
        $startTime = microtime(true);

        $output = \Aiden\Classes\SwissKnife::getOutput($scrapeUrl->scrape_url);

        $message = sprintf('> Sending GET request to [%s]...', $scrapeUrl->scrape_url);
        $this->logger->info($message);


        // get content on accordion ajax
        $html = \str_get_html($output);
        if ($html) {
            $listContainer = $html->find('.accordion-list-container', 0);
            if ($listContainer) {
                $listItem = $listContainer->find('.accordion-list-item-container');
                foreach ($listItem as $list) {
                    $trigger = $list->find('.accordion-trigger', 0);
                    if ($trigger) {
                        $cvid = $trigger->getAttribute('data-cvid');
                        echo $cvid . '<br>';
                        // get ajax url to fetch contents
                        $ajaxUrl = "https://www.blacktown.nsw.gov.au/OCServiceHandler.axd?url=ocsvc/public/meetings/documentrenderer&keywords=&cvid=$cvid";
                        $output = \Aiden\Classes\SwissKnife::getOutput($ajaxUrl);
                        $output = json_decode($output, true);
                        //        // Get all the URLs from the first page
                        $urlsOnFirstPage = $this->getAllUrlsOnPageByContentBlacktown($output['html'], $scrapeUrl);

                        foreach ($urlsOnFirstPage as $urlOnFirstPage) {

                            // If URL is pointing to a PDF, add to array which will later save the PDF to the database
                            if (preg_match($scrapeUrl->regex_pattern, $urlOnFirstPage)) {
                                $pdfUrls[] = $urlOnFirstPage;
                            } // Else queue the URL for scraping.
                            else {
                                if (!in_array($urlOnFirstPage, $scrapedUrls) && !in_array($urlOnFirstPage, $adjacentUrls)) {
                                    $adjacentUrls[] = $urlOnFirstPage;
                                }
                            }
                        }
                        $scrapedUrls[] = $scrapeUrl->scrape_url;
                        // Keep following links until we've reached max depth, if a scrapeUrl has 0 depth, it will skip this entire loop.
                        while ($currentDepth < $scrapeUrl->depth_level) {

                            // Log
                            $message = sprintf('> Diving to depth level [%s]...', $currentDepth + 1);
                            echo $message . '<br>';
                            $this->logger->info($message);

                            // Move adjacent URLs to queue array (this is so we can limit the amount of requests)
                            $queuedUrls = $adjacentUrls;

                            // Empty the adjacent URLs array so we can add fresh ones.
                            $adjacentUrls = [];

                            // Limit the amount of requests by slicing and splicing the queued URL until empty
                            while (count($queuedUrls) > 0) {

                                $itemsToSliceAndSplice = min([count($queuedUrls), $this->config->application->maxConcurrentRequests]); // Limit concurrent requests
                                $urlsToScrape = array_slice($queuedUrls, 0, $itemsToSliceAndSplice); // Copy the elements to one array
                                array_splice($queuedUrls, 0, $itemsToSliceAndSplice); // Remove the elements from the queue array

                                $urls = [];
                                foreach ($urlsToScrape as $urlToScrape) {

                                    // Only add non-scraped URLs
                                    if (!in_array($urlToScrape, $scrapedUrls)) {
                                        $urls[$urlToScrape]['scrapeUrl'] = $scrapeUrl;
                                    }
                                }

                                // Get content async
                                $urls = self::getContentFromMultipleUrlsAsync($urls);

                                foreach ($urls as $url => $properties) {

                                    if ($properties['curl_info']['http_code'] != 200) {

                                        $message = sprintf('> [%s] returned status [%s]...', $url, $properties['curl_info']['http_code']);
                                        echo $message . '<br>';
                                        $this->logger->error($message);

                                        continue;
                                    }

                                    $message = sprintf('> Processing [%s]...', $url);
                                    $this->logger->info($message);

                                    // Retrieve all URLs from the $urlToScrape, we pass $scrapeUrl so we can
                                    // create absolute URLs for websites that only show relative ones.
                                    $urlsOnPage = $this->getAllUrlsOnPageByContent($properties['content'], $properties['scrapeUrl']);

                                    $message = sprintf('> Found [%s] URLs on [%s]...', count($urlsOnPage), $url);
                                    echo $message . '<br>';
                                    //$this->logger->info($message);

                                    foreach ($urlsOnPage as $urlOnPage) {

                                        // If URL is pointing to a PDF, add to array which will later save the PDF to the database
                                        if (preg_match($properties['scrapeUrl']->regex_pattern, $urlOnPage)) {

                                            $pdfUrls[] = $urlOnPage;
                                        } // Else queue the URL for scraping.
                                        else {

                                            if (!in_array($urlOnPage, $scrapedUrls) && !in_array($urlOnPage, $adjacentUrls)) {
                                                $adjacentUrls[] = $urlOnPage;
                                            }
                                        }
                                    }

                                    $scrapedUrls[] = $url;
                                }
                            }
                            $currentDepth++;
                        }



                        $endTime = microtime(true);
                        $executionSeconds = ceil(($endTime - $startTime) / 60);


                        $this->addPdfUrls($pdfUrls, $scrapeUrl->ScrapeSource);

                        $scrapeUrl->last_crawl = date('Y-m-d H:i:s');
                        if ($scrapeUrl->save()) {

                            $message = sprintf('> Finished scraping [%s] successfully in [%s] seconds. Found [%s] PDF URLs.', $scrapeUrl->scrape_url, $executionSeconds, count($pdfUrls));
                            $this->logger->info($message);
                        } else {

                            $message = sprintf('> Finished scraping [%s] with errors in [%s] seconds. Found [%s] PDF URLs.', $scrapeUrl->scrape_url, $executionSeconds, count($pdfUrls));
                            $this->logger->info($message);
                        }
                    }
                }
            }
        }


    }

    public function addPdfUrls($urls, \Aiden\Models\ScrapeSources $scrapeSource)
    {

// Process PDF URLs
        foreach ($urls as $url) {
            $existingPdf = \Aiden\Models\Pdfs::findFirstByUrl($url);
            if ($existingPdf) {
                continue;
            }

            $pdf = new \Aiden\Models\Pdfs();
            $pdf->scrape_sources_id = $scrapeSource->id;
            $pdf->url = $url;
            $pdf->checksum = null;

            if ($pdf->save()) {

                $message = sprintf('Added [%s] to PDF database.', $url);
                echo $message . '<br>';
                $this->logger->info($message);
            } else {

                $message = sprintf('Could not add [%s] to PDF database. (%s)', $url, print_r($pdf->getMessages(), true));
                echo $message . '<br>';
                $this->logger->error($message);
            }
        }

    }

    public function getAllUrlsOnPageByUrl($url, \Aiden\Models\ScrapeUrls $scrapeUrl)
    {

// Get output from Scrape URL
        $output = \Aiden\Classes\SwissKnife::getOutput($url);
        if ($output === false) {

            $message = sprintf('Could not scrape [%s], output was false.', $url);
            $this->logger->error($message);
            return false;
        }

        $this->getAllUrlsOnPageByContent($output, $scrapeUrl);

    }

    public function getAllUrlsOnPageByContent($output, \Aiden\Models\ScrapeUrls $scrapeUrl)
    {

        // Parse HTML
        $html = \str_get_html($output);
        if ($html === false) {

            $logMessage = sprintf('Could not parse HTML.');
            $this->logger->error($logMessage);
            return false;
        }

        $urls = [];

        $elements = $html->find('*[href]');
        foreach ($elements as $element) {

            if (!isset($element->href) || strlen($element->href) === 0) {
                continue;
            }

            // Some websits only show relative URLs, convert these to absolute ones.
            $fullUrl = \phpUri::parse($scrapeUrl->scrape_url)->join(html_entity_decode($element->href));


            // TODO: Refactor, skips mailto URLs
            if (strpos($fullUrl, 'mailto:') !== false) {
                continue;
            }

            // Check if URL is valid
            if (!filter_var($fullUrl, FILTER_VALIDATE_URL)) {
                continue;
            }

            // Check if URL is from the same domain
            if ($scrapeUrl->check_domain) {

                $scrapeDomain = \Aiden\Classes\SwissKnife::getDomainFromUrl($scrapeUrl->scrape_url);
                $urlDomain = \Aiden\Classes\SwissKnife::getDomainFromUrl($fullUrl);

                if ($scrapeDomain !== $urlDomain) {
                    continue;
                }
            }

            if (!in_array($fullUrl, $urls)) {
                $urls[] = $fullUrl;
            }
        }
        return $urls;

    }


    public function getAllUrlsOnPageByContentBlacktown($output, \Aiden\Models\ScrapeUrls $scrapeUrl)
    {

        // Parse HTML
        $html = \str_get_html($output);
        if ($html === false) {

            $logMessage = sprintf('Could not parse HTML.');
            $this->logger->error($logMessage);
            return false;
        }

        $urls = [];

        $elements = $html->find('*[href]');
        foreach ($elements as $element) {

            if (!isset($element->href) || strlen($element->href) === 0) {
                continue;
            }

            // Some websits only show relative URLs, convert these to absolute ones.
            $fullUrl = 'https://www.blacktown.nsw.gov.au'.html_entity_decode($element->href);


            // TODO: Refactor, skips mailto URLs
            if (strpos($fullUrl, 'mailto:') !== false) {
                continue;
            }

            // Check if URL is valid
            if (!filter_var($fullUrl, FILTER_VALIDATE_URL)) {
                continue;
            }

            // Check if URL is from the same domain
            if ($scrapeUrl->check_domain) {

                $scrapeDomain = \Aiden\Classes\SwissKnife::getDomainFromUrl($scrapeUrl->scrape_url);
                $urlDomain = \Aiden\Classes\SwissKnife::getDomainFromUrl($fullUrl);

                if ($scrapeDomain !== $urlDomain) {
                    continue;
                }
            }

            if (!in_array($fullUrl, $urls)) {
                $urls[] = $fullUrl;
            }
        }
        return $urls;

    }

    public static function getContentFromMultipleUrlsAsync($urls)
    {

        /* A location is structured as follows:
         * $locations['https://google.com'] => $location
         * We will then later add content and curl_info
         * $location['content'] = <div class="content"></div>
         * $location['curl_info'] = Array();
         */

        $di = \Phalcon\DI::getDefault();

        $curlHandles = [];
        foreach ($urls as $url => $properties) {

            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $url);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
            curl_setopt($curlHandle, CURLOPT_HEADER, 0);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
            $curlHandles[$url] = $curlHandle;
        }

        // Add the handles to the master curl handle
        $multiCurlHandle = curl_multi_init();
        foreach ($curlHandles as $identifier => $curlHandle) {
            curl_multi_add_handle($multiCurlHandle, $curlHandle);
        }

        /* Execute the requests
         * There's two outer loops, the first one is responsible
         * for clearing out the curl buffer right now. The second one
         * is responsible for waiting for more information. And then
         * getting that information. This is an example of what is called Blocking I/O
         * We block execution of the rest of the program until the network I/O is done.
         * Not the most preferable way, but our only choice :'(((( 
         */
        $active = null;
        do {
            curl_multi_exec($multiCurlHandle, $active);
        } while ($active > 0);

        while ($active && $mrc == CURLM_OK) {

            if (curl_multi_select($mh) == -1) {

                usleep(1); // Windhose fix
            } else {

                do {

                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        foreach ($curlHandles as $url => $curlHandle) {

            $urls[$url]['content'] = curl_multi_getcontent($curlHandle);
            $urls[$url]['curl_info'] = curl_getinfo($curlHandle);
            curl_multi_remove_handle($multiCurlHandle, $curlHandle);
        }

        curl_multi_close($multiCurlHandle);
        return $urls;

    }

}
