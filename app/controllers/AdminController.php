<?php

namespace Aiden\Controllers;

class AdminController extends _BaseController {

    public function indexAction() {

        $di = \Phalcon\DI::getDefault();
        $config = $di->getConfig();

        // Count results for pagination
        $page = ($this->request->getQuery('page', 'int') != null ? $this->request->getQuery('page', 'int') : 1);
        $limit = 25;
        $offset = ($page - 1) * $limit;


        $phql = "SELECT [Aiden\Models\Pdfs].*"
            . " FROM [Aiden\Models\Pdfs]"
            . " INNER JOIN [Aiden\Models\Matches]"
            . " ON [Aiden\Models\Matches].pdf_id = [Aiden\Models\Pdfs].id"
            . " WHERE 1=1"
            . " AND [Aiden\Models\Pdfs].checksum IS NOT NULL"
            . " GROUP BY [Aiden\Models\Pdfs].id"
            . " ORDER BY [Aiden\Models\Pdfs].last_checked DESC";

        $pdfsCount = count($this->modelsManager->executeQuery($phql));
        $totalPages = ceil($pdfsCount / $limit);

        // Grab only PDFs containing phrases
        $phql = "SELECT [Aiden\Models\Pdfs].*"
                . " FROM [Aiden\Models\Pdfs]"
                . " INNER JOIN [Aiden\Models\Matches]"
                . " ON [Aiden\Models\Matches].pdf_id = [Aiden\Models\Pdfs].id"
                . " WHERE 1=1"
                . " AND [Aiden\Models\Pdfs].checksum IS NOT NULL"
                . " GROUP BY [Aiden\Models\Pdfs].id"
                . " ORDER BY [Aiden\Models\Pdfs].last_checked DESC"
                . " LIMIT ".$offset.','.$limit;


        $pdfs = $this->modelsManager->executeQuery($phql);

        $this->view->setVars([
            'pdfs' => $pdfs,
            'page' => array(
                'current' => $page,
                'next' => $page + 1,
                'totalPages' => $totalPages,

            ),
            'pageTitle' => 'Crawler Admin'
        ]);

    }

}
