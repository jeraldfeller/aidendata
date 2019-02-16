<?php

namespace Aiden\Models;

class ScrapeSources extends \Phalcon\Mvc\Model {

    public $id;
    public $name;
    public $last_crawl;

    public function initialize() {

        $this->hasMany('id', 'Aiden\Models\Pdfs', 'scrape_sources_id', [
            'alias' => 'Pdfs'
        ]);

        $this->hasMany('id', 'Aiden\Models\ScrapeUrls', 'scrape_sources_id', [
            'alias' => 'ScrapeUrls'
        ]);

    }

    public function getSource() {
        return 'scrape_sources';

    }

    public function hasAllPdfsAnalysed() {

        $analysedPdfs = \Aiden\Models\Pdfs::find([
                    'conditions' => 'scrape_sources_id = :scrape_sources_id: AND checksum IS NOT NULL',
                    'bind' => ['scrape_sources_id' => $this->id]
        ]);

        if (count($analysedPdfs) === count($this->Pdfs)) {
            return true;
        } else {
            return false;
        }

    }

}
