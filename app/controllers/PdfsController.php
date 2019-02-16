<?php

namespace Aiden\Controllers;

class PdfsController extends _BaseController {

    public function indexAction() {

        // Create pagination model
        $paginator = new \Phalcon\Paginator\Adapter\Model([
            'data' => \Aiden\Models\Pdfs::find('1=1 ORDER BY id DESC'),
            'limit' => $this->config->application->maxItemsPerPage,
            'page' => $this->request->getQuery('page', 'int'),
        ]);

        $this->view->setVars([
            'pageTitle' => 'PDFs',
            'page' => $paginator->getPaginate(),
        ]);

    }

    public function deleteAction() {

        if (!$this->request->hasQuery('id')) {
            $this->flashSession->error('Invalid request');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $pdf = \Aiden\Models\Pdfs::findFirstById($this->request->getQuery('id'));
        if (!$pdf) {
            $this->flashSession->error('Could not find PDF');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $pdfUrl = $pdf->url;
        if ($pdf->delete()) {

            $message = sprintf('[%s] has been deleted.', $pdfUrl);
            $this->flashSession->success($message);
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

    }

    public function viewAction() {

        if (!$this->request->hasQuery('id')) {
            $this->flashSession->error('Invalid request');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $pdf = \Aiden\Models\Pdfs::findFirstById($this->request->getQuery('id'));
        if (!$pdf) {
            $this->flashSession->error('Could not find PDF');
            return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
        }

        $this->view->setVars([
            'pageTitle' => $pdf->ScrapeSource->name . ' PDF #' . $pdf->id,
            'pdf' => $pdf,
        ]);

    }

}
