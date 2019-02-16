<?php

namespace Aiden\Controllers;

class UrlsController extends _BaseController {

    public function createAction() {

        // Check if POST request.
        if ($this->request->isPost() === false) {

            $this->flashSession->error('Invalid request');
            return $this->response->redirect('management', false, 302);
        }

        // Validate the form
        $form = new \Aiden\Forms\CreateScrapeUrlForm();
        if (!$form->isValid($this->request->getPost())) {

            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->response->redirect('management', false, 302);
        }

        // TODO: Make validator... InclusionIn()!
        $scrapeSource = \Aiden\Models\ScrapeSources::findFirstById($this->request->getPost('source_id'));
        if (!$scrapeSource) {

            $this->flashSession->error('The specified source could not be found.');
            return $this->response->redirect('management', false, 302);
        }

        $inputScrapeUrl = trim($this->request->getPost('source_scrape_url'));
        $inputRegexPattern = $this->request->getPost('source_regex_pattern');
        $inputCheckAdjacent = (int) $this->request->hasPost('source_check_adjacent');
        $inputAdjacentPagesDepth = (int) $this->request->getPost('source_depth_level');
        $inputCheckDomain = (int) $this->request->hasPost('source_check_domain');
        $inputIsPost = (int) $this->request->hasPost('source_is_post');
        $inputPostParams = $this->request->getPost('source_post_params');
        $inputUrlEncoded = (int) $this->request->hasPost('source_url_encoded');

        $scrapeUrl = new \Aiden\Models\ScrapeUrls();
        $scrapeUrl->scrape_sources_id = $scrapeSource->id;
        $scrapeUrl->scrape_url = $inputScrapeUrl;
        $scrapeUrl->regex_pattern = $inputRegexPattern;
        $scrapeUrl->check_adjacent = $inputCheckAdjacent;
        $scrapeUrl->depth_level = $inputAdjacentPagesDepth;
        $scrapeUrl->check_domain = $inputCheckDomain;
        $scrapeUrl->is_post = $inputIsPost;
        $scrapeUrl->post_params = $inputPostParams;
        $scrapeUrl->form_urlencoded = $inputUrlEncoded;

        if ($scrapeUrl->save()) {

            $message = sprintf('[%s] has been added to [%s].', $inputScrapeUrl, $scrapeSource->name);
            $this->flashSession->success($message);

            return $this->response->redirect('sources', false, 302);
        }
        else {

            foreach ($scrapeSource->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->response->redirect('sources', false, 302);
        }


    }

    public function deleteAction() {

        if (!$this->request->hasQuery('id')) {
            $this->flashSession->error('Invalid request');
            return $this->response->redirect('sources', false, 302);
        }

        $scrapeUrl = \Aiden\Models\ScrapeUrls::findFirstById($this->request->getQuery('id'));
        if (!$scrapeUrl) {
            $this->flashSession->error('Could not find scrape URL');
            return $this->response->redirect('sources', false, 302);
        }

        $scrapeUrlText = $scrapeUrl->scrape_url;
        if ($scrapeUrl->delete()) {

            $message = sprintf('[%s] has been deleted.', $scrapeUrlText);
            $this->flashSession->success($message);
            return $this->response->redirect('sources', false, 302);
        }


    }

    public function scrapeAction() {

        $this->dispatcher->forward([
            'controller' => 'scrape',
            'action' => 'scrapeUrlById'
        ]);


    }

}
