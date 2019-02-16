<?php

namespace Aiden\Controllers;

class ManagementController extends _BaseController {

    public function indexAction() {

        $this->view->setVars([
            'pageTitle' => 'Management',
            'phraseForm' => new \Aiden\Forms\CreatePhraseForm(),
            'scrapeSourceForm' => new \Aiden\Forms\CreateScrapeSourceForm(),
            'scrapeUrlForm' => new \Aiden\Forms\CreateScrapeUrlForm(),
        ]);

    }

}
