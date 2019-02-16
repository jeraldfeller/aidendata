<?php

namespace Aiden\Forms;

class CreateScrapeUrlForm extends \Phalcon\Forms\Form {

    public function initialize() {

        // Source name
        $scrapeSources = \Aiden\Models\ScrapeSources::find();
        $source = new \Phalcon\Forms\Element\Select('source_id', $scrapeSources, [
            'class' => 'form-control',
            'useEmpty' => true,
            'autofocus' => '',
            'required' => '',
            'using' => ['id', 'name'],
            'style' => 'height: 100%;'
        ]);
        $source
                ->setLabel('Source:');
        $this->add($source);

        // Scrape URL
        $sourceScrapeUrl = new \Phalcon\Forms\Element\Text('source_scrape_url', [
            'class' => 'form-control',
            'placeholder' => 'e.g. http://www.example.com/pdfs/',
            'required' => '',
        ]);
        $sourceScrapeUrl
                ->setLabel('Scrape URL:')
                ->addValidators([
                    new \Phalcon\Validation\Validator\StringLength([
                        'max' => 1024,
                        'min' => 1,
                        'messageMaximum' => 'The specified scrape URL is too long.',
                        'messageMinimum' => 'The specified scrape URL is too short.',
                        'cancelOnFail' => true,
                            ]),
                    new \Phalcon\Validation\Validator\Uniqueness([
                        'message' => 'The specified scrape URL is already in the database.',
                        'model' => new \Aiden\Models\ScrapeUrls(),
                        'attribute' => 'scrape_url'
                            ]),
        ]);
        $this->add($sourceScrapeUrl);

        // Scrape URL
        $sourceRegexPattern = new \Phalcon\Forms\Element\Text('source_regex_pattern', [
            'class' => 'form-control',
            'value' => '/(.+)\.pdf/i',
            'required' => '',
        ]);
        $sourceRegexPattern
                ->setLabel('Regular Expression Pattern:')
                ->addValidators([
                    new \Phalcon\Validation\Validator\StringLength([
                        'max' => 1024,
                        'min' => 1,
                        'messageMaximum' => 'The specified pattern is too long.',
                        'messageMinimum' => 'The specified pattern is too short.',
                        'cancelOnFail' => true,
                            ]),
        ]);
        $this->add($sourceRegexPattern);

        // CHECK ADJACENT PAGES?
        $checkAdjacent = new \Phalcon\Forms\Element\Check('source_check_adjacent', [
            'value' => 1,
            'class' => 'form-check-input'
        ]);
        $checkAdjacent->setLabel('Check adjacent pages?');
        $this->add($checkAdjacent);

        // DEPTH LEVEL
        $depthLevel = new \Phalcon\Forms\Element\Numeric('source_depth_level', [
            'class' => 'form-control',
            'value' => 0,
            'required' => '',
        ]);
        $depthLevel->setLabel('Adjacent pages depth');
        $this->add($depthLevel);

        // CHECK DOMAIN?
        $checkDomain = new \Phalcon\Forms\Element\Check('source_check_domain', [
            'value' => 0,
            'class' => 'form-check-input'
        ]);
        $checkDomain->setLabel('Check domain host?');
        $this->add($checkDomain);

        // IS POST?
        $isPost = new \Phalcon\Forms\Element\Check('source_is_post', [
            'value' => 0,
            'class' => 'form-check-input'
        ]);
        $isPost->setLabel('POST Request?');
        $this->add($isPost);

        // POST PARAMS?
        $postParams = new \Phalcon\Forms\Element\Text('source_post_params', [
            'class' => 'form-control',
            'value' => '',
            'placeholder' => 'e.g. foo=bar&bar=foo',
        ]);
        $postParams->setLabel('POST Parameters');
        $this->add($postParams);

        // FORM URL ENCODED?
        $urlEncoded = new \Phalcon\Forms\Element\Check('source_url_encoded', [
            'value' => 0,
            'class' => 'form-check-input'
        ]);
        $urlEncoded->setLabel('x-www-form-urlencoded (<small>instead of multipart/form-data</small>)?');
        $this->add($urlEncoded);


        // Submit
        $submit = new \Phalcon\Forms\Element\Submit('submit', [
            'value' => 'Submit',
            'class' => 'btn btn-success'
        ]);
        $this->add($submit);


    }

}
