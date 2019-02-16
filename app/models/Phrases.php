<?php

namespace Aiden\Models;

class Phrases extends \Phalcon\Mvc\Model {

    public $id;
    public $text;
    public $case_sensitive;

    public function initialize() {

        $this->hasMany('id', 'Aiden\Models\Matches', 'phrase_id', [
            'alias' => 'Matches'
        ]);

    }

    public function getSource() {
        return 'phrases';

    }

}
