<?php

namespace Aiden\Models;

class Users extends \Phalcon\Mvc\Model {

    const LEVEL_ADMINISTRATOR = 255;
    const LEVEL_USER = 1;
    const LEVEL_GUEST = 0;

    public $id;
    public $email;
    public $password;
    public $level;

    public function getSource() {
        return 'users';
    }

}
