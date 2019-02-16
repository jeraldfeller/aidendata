<?php

namespace Aiden\Controllers;

class ErrorsController extends _BaseController {

    public function show404Action() {
        echo '404 - Page not found';
        $this->view->disable();

    }

    public function show403Action() {
        echo '403 - Forbidden';
        $this->view->disable();

    }

    public function show401Action() {

        if ($this->session->has('auth')) {

            $auth = $this->session->get('auth');
            if ($auth['user']->level == \Aiden\Models\Users::LEVEL_USER) {

                echo 'Your account needs to be elevated before you can proceed. Please contact an administrator.<br>';

                $administrators = \Aiden\Models\Users::findByLevel(\Aiden\Models\Users::LEVEL_ADMINISTRATOR);
                foreach ($administrators as $administrator) {

                    echo '> ' . $administrator->email . '<br>';
                }
                $this->view->disable();
                return;
            }
        }

        echo '401 - Unauthorized';
        $this->view->disable();

    }

}
