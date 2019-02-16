<?php

namespace Aiden\Models;

class Pdfs extends \Phalcon\Mvc\Model {

    public $id;
    public $scrape_sources_id;
    public $filename;
    public $url;
    public $checksum;
    public $last_checked;

    public function initialize() {

        $this->belongsTo('scrape_sources_id', 'Aiden\Models\ScrapeSources', 'id', [
            'alias' => 'ScrapeSource'
        ]);

        $this->hasMany('id', 'Aiden\Models\Matches', 'pdf_id', [
            'alias' => 'Matches'
        ]);

    }

    public function getSource() {
        return 'pdfs';

    }

    public function getUnprocessedMatches() {

        return $this->getRelated('Matches', 'processed = 0');

    }

    public function getStatusString() {

        if ($this->checksum === null) {
            return 'Unprocessed';
        }
        else {
            return 'Processed';
        }

    }

    public function getFileName() {

        $urlParts = explode('/', $this->url);
        return $urlParts[count($urlParts) - 1];

    }

}
