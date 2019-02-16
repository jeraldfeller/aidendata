<?php

namespace Aiden\Models;

class Matches extends \Phalcon\Mvc\Model {

    public $id;
    public $pdf_id;
    public $phrase_id;
    public $excerpt;
    public $page;
    public $processed;

    public function initialize() {

        $this->belongsTo('pdf_id', '\Aiden\Models\Pdfs', 'id', [
            'alias' => 'Pdf'
        ]);

        $this->belongsTo('phrase_id', '\Aiden\Models\Phrases', 'id', [
            'alias' => 'Phrase'
        ]);

    }

    public function getSource() {
        return 'matches';

    }

    public function getHighlightedExcerptHtml() {

        $replacePattern = '/' . strtolower($this->Phrase->text) . '/i';
        $replaceString = "<span style=\"background-color: yellow;\">\$0</span>";
        $emphasisedExcerpt = preg_replace($replacePattern, $replaceString, htmlentities($this->excerpt));
        return $emphasisedExcerpt;

    }

}
