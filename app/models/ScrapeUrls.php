<?php

namespace Aiden\Models;

class ScrapeUrls extends \Phalcon\Mvc\Model {

    public $id;
    public $scrape_sources_id;
    public $scrape_url;
    public $regex_pattern;
    public $check_adjacent;
    public $depth_level;
    public $check_domain;
    public $is_post;
    public $post_params;
    public $form_urlencoded;
    public $last_crawl;

    public function getSource() {
        return 'scrape_urls';


    }

    public function initialize() {

        $this->belongsTo('scrape_sources_id', 'Aiden\Models\ScrapeSources', 'id', [
            'alias' => 'ScrapeSource'
        ]);


    }

    public function getShorterUrl() {

        $maxLength = 50;

        if (strlen($this->scrape_url) <= $maxLength) {
            return $this->scrape_url;
        }
        else {
            return substr($this->scrape_url, 0, $maxLength - 3) . '...';
        }


    }

}
