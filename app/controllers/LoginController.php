<?php

namespace Aiden\Controllers;

class LoginController extends _BaseController {

    public function indexAction() {

        // If user is already logged in
        if ($this->session->has('auth')) {
            return $this->response->redirect('admin', false, 302);
        }

        $this->view->setVars([
            'pageTitle' => 'Login',
            'form' => new \Aiden\Forms\LoginForm()
        ]);

    }

    public function doAction() {

        // Check if POST request.
        if ($this->request->isPost() === false) {

            $this->flashSession->error('Invalid request');
            return $this->response->redirect('login', false, 302);
        }

        // Validate the form
        $form = new \Aiden\Forms\LoginForm();
        if (!$form->isValid($this->request->getPost())) {

            foreach ($form->getMessages() as $message) {

                $this->flashSession->error($message);
                return $this->response->redirect($this->dispatcher->getControllerName(), false, 302);
            }
        }

        $email = $this->request->getPost('email', 'email');
        $password = $this->request->getPost('password');

        // Check whether there's a user with this email
        $user = \Aiden\Models\Users::findFirstByEmail($email);
        if ($user == false) {

            $errorMessage = sprintf('User with email address %s was not found.', $email);
            $this->flashSession->error($errorMessage);
            return $this->response->redirect('login', false, 302);
        }
        else {

            // DEBUG
            if ($this->security->checkHash($password, $user->password)) {
                $this->session->set('auth', [
                    'user' => $user
                ]);
                return $this->response->redirect('admin', false, 302);
            }
            // If password don't match, show generic message. Email might be right but 
            // you don't want to tell a bruteforcer that.
            else {

                $errorMessage = sprintf('User with email address %s was not found.', $email);
                $this->flashSession->error($errorMessage);
                return $this->response->redirect('dashboard', false, 302);
            }
        }

    }

    public function destroyAction() {

        $this->session->destroy();
        return $this->response->redirect('', false, 302);

    }

}
