<?php
namespace Aiden\Models;

class QueuedPdfs extends \Phalcon\Mvc\Model {

    public $id;
    public $url;
    public $scrape_sources_id;
    public $created;
    public $processed;

    public function getSource() {
        return 'queued_pdfs';

    }

    public function initialize() {

        $this->belongsTo('scrape_sources_id', 'Aiden\Models\ScrapeSources', 'id', [
            'alias' => 'ScrapeSource'
        ]);

    }

}
