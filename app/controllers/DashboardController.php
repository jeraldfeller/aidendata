<?php

namespace Aiden\Controllers;

use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Aiden\Models\ScrapeSources;
use Aiden\Models\Pdfs;

class DashboardController extends _BaseController {

    public function indexAction() {

        $from = $this->request->get('from', null, (new \DateTime('first day of this month'))->format('d-m-Y'));
        $to = $this->request->get('to', null, (new \DateTime('today'))->format('d-m-Y'));

        if (strtotime($from) > strtotime($to)) {
            $from = $to;
        }
        $statistics = $this->getStatisticAction(date('Y-m-d 00:00:00', strtotime($from)), date('Y-m-d 23:59:59', strtotime($to)));

        // Grab only PDFs containing phrases
        $phql = "SELECT [Aiden\Models\Pdfs].*"
                . " FROM [Aiden\Models\Pdfs]"
                . " WHERE 1=1"
                . " AND [Aiden\Models\Pdfs].checksum IS NOT NULL"
                . " ORDER BY [Aiden\Models\Pdfs].id DESC"
                . " LIMIT 25";

        $pdfs = $this->modelsManager->executeQuery($phql);

        $this->view->setVars([
            'pdfs' => $pdfs,
            'pageTitle' => 'Dashboard',
            'firstDoM' => $from,
            'today' => $to,
            'statistics' => $statistics,
        ]);

    }

    public function getStatisticAction($from, $to) {

        $statistics = [];

        // Get this period's PDFs
        $periodPdfsPhql = "SELECT [Aiden\Models\Pdfs].*"
                . " FROM [Aiden\Models\Pdfs]"
                . " WHERE [Aiden\Models\Pdfs].last_checked BETWEEN :from: AND :to:";

        $periodPdfs = $this->modelsManager->executeQuery($periodPdfsPhql, [
            "from" => $from,
            "to" => $to
        ]);

        $statistics["periodPdfs_count"] = $periodPdfs->count();
        $statistics["periodPdfs"] = $periodPdfs;


        // Get this period's phrases
        $periodPhrasesPhql = "SELECT [Aiden\Models\Matches].*"
                . " FROM [Aiden\Models\Matches]"
                . " INNER JOIN [Aiden\Models\Pdfs]"
                . " ON [Aiden\Models\Matches].pdf_id = [Aiden\Models\Pdfs].id"
                . " WHERE [Aiden\Models\Pdfs].last_checked BETWEEN :from: AND :to:";

        $periodPhrases = $this->modelsManager->executeQuery($periodPhrasesPhql, [
            "from" => $from,
            "to" => $to
        ]);

        $statistics["periodPhrasesFound_count"] = $periodPhrases->count();
        $statistics["periodPhrasesFound"] = $periodPhrases;

        // Get this period's scrape sources
        $phql = "SELECT [Aiden\Models\ScrapeSources].name, COUNT([Aiden\Models\Pdfs].scrape_sources_id) as count"
                . " FROM [Aiden\Models\ScrapeSources]"
                . " INNER JOIN [Aiden\Models\Pdfs]"
                . " ON [Aiden\Models\ScrapeSources].id = [Aiden\Models\Pdfs].scrape_sources_id"
                . " WHERE [Aiden\Models\Pdfs].last_checked BETWEEN :from: AND :to:"
                . " GROUP BY [Aiden\Models\ScrapeSources].id"
                . " ORDER BY count DESC"
                . " LIMIT 5";

        $periodScrapeSources = $this->modelsManager->executeQuery($phql, [
            "from" => $from,
            "to" => $to
        ]);

        $statistics["periodScrapeSources_count"] = $periodScrapeSources->count();
        $statistics["periodScrapeSources"] = $periodScrapeSources;

        // Add Total Councils + Total PDFs
        $statistics["totalCouncils_count"] = ScrapeSources::find()->count();
        $statistics["totalPdfs_count"] = Pdfs::find()->count();

        return $statistics;

    }

}
