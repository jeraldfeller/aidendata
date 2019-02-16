<?php

namespace Aiden\Controllers;

class SourcesController extends _BaseController {

    public function indexAction() {

        $this->view->setVars([
            'pageTitle' => 'Scraping Sources',
            'scrapeSources' => \Aiden\Models\ScrapeSources::find(),
            'form' => new \Aiden\Forms\CreateScrapeSourceForm(),
        ]);

    }

    public function createAction() {

        // Check if POST request.
        if ($this->request->isPost() === false) {

            $this->flashSession->error('Invalid request');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        // Validate the form
        $form = new \Aiden\Forms\CreateScrapeSourceForm();
        if (!$form->isValid($this->request->getPost())) {

            foreach ($form->getMessages() as $message) {

                $this->flashSession->error($message);
                return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
            }
        }

        $sourceName = trim($this->request->getPost('source_name'));
        $sourceBaseUrl = trim($this->request->getPost('source_base_url'));
        $sourceScrapeUrl = trim($this->request->getPost('source_scrape_url'));
        $sourceRegexPattern = $this->request->getPost('source_regex_pattern');
        $sourceCheckAdjacent = (int) $this->request->hasPost('source_check_adjacent');

        // Check if name already exists
        if (\Aiden\Models\ScrapeSources::findFirstByName($sourceName)) {
            $this->flashSession->error('The specified source name already exists');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $scrapeSource = new \Aiden\Models\ScrapeSources();
        $scrapeSource->name = $sourceName;
        $scrapeSource->base_url = $sourceBaseUrl;
        $scrapeSource->scrape_url = $sourceScrapeUrl;
        $scrapeSource->regex_pattern = $sourceRegexPattern;
        $scrapeSource->check_adjacent = $sourceCheckAdjacent;
        $scrapeSource->last_crawl = null;

        if ($scrapeSource->save()) {

            $message = sprintf('[%s] has been created.', $scrapeSource->name);
            $this->flashSession->success($message);

            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }
        else {

            foreach ($scrapeSource->getMessages() as $message) {

                $this->flashSession->error($message);
                return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
            }
        }

    }

    public function deleteAction() {

        if (!$this->request->hasQuery('id')) {
            $this->flashSession->error('Invalid request');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $scrapeSource = \Aiden\Models\ScrapeSources::findFirstById($this->request->getQuery('id'));
        if (!$scrapeSource) {
            $this->flashSession->error('Could not find scraping source');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $scrapeSourceName = $scrapeSource->name;
        if ($scrapeSource->delete()) {

            $message = sprintf('[%s] has been deleted.', $scrapeSourceName);
            $this->flashSession->success($message);
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

    }



}
