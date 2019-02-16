<?php

namespace Aiden\Controllers;

class PhrasesController extends _BaseController {

    public function indexAction() {

        $this->view->setVars([
            'pageTitle' => 'Phrases',
            'phrases' => \Aiden\Models\Phrases::find(),
            'form' => new \Aiden\Forms\CreatePhraseForm(),
        ]);

    }

    public function createAction() {

        // Check if POST request.
        if ($this->request->isPost() === false) {

            $this->flashSession->error('Invalid request');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        // Validate the form
        $form = new \Aiden\Forms\CreatePhraseForm();
        if (!$form->isValid($this->request->getPost())) {

            foreach ($form->getMessages() as $message) {

                $this->flashSession->error($message);
                return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
            }
        }

        $phraseText = trim($this->request->getPost('phrase'));
        $phraseCaseSensitive = (int) $this->request->hasPost('case_sensitive');

        // Check if name already exists
        if (\Aiden\Models\Phrases::findFirstByText($phraseText)) {
            $this->flashSession->error('The specified phrase already exists');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $phrase = new \Aiden\Models\Phrases();
        $phrase->text = $phraseText;
        $phrase->case_sensitive = $phraseCaseSensitive;

        if ($phrase->save()) {

            $message = sprintf('[%s] has been added.', $phrase->text);
            $this->flashSession->success($message);
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }
        else {

            foreach ($phrase->getMessages() as $message) {

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

        $phrase = \Aiden\Models\Phrases::findFirstById($this->request->getQuery('id'));
        if (!$phrase) {
            $this->flashSession->error('Could not find phrase');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $phraseText = $phrase->text;
        if ($phrase->delete()) {

            $message = sprintf('[%s] has been deleted.', $phraseText);
            $this->flashSession->success($message);
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

    }

    public function toggleCaseAction() {


        if (!$this->request->hasQuery('id')) {
            $this->flashSession->error('Invalid request');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $phrase = \Aiden\Models\Phrases::findFirstById($this->request->getQuery('id'));
        if (!$phrase) {
            $this->flashSession->error('Could not find phrase');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $phrase->case_sensitive = (int) (!(bool) $phrase->case_sensitive);
        $phrase->save();
        return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);

    }

}
