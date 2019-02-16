<?php

namespace Aiden\Controllers;

class _BaseController extends \Phalcon\Mvc\Controller {

    public function initialize() {
        $this->setUrlVariables();

    }

    public function setUrlVariables() {

        // These keys in $this->request->getQuery() should be skipped.
        $skipKeys = [
            '_url',
            'page' // This bit will be added in pagination.volt
        ];

        $parameters = ''; // Everything after the hostname.domain
        $getKeys = $this->request->getQuery(); // $_GET
        $numOfAddedParameters = 0;

        // Rebuild the URL (without $skipKeys)
        foreach ($getKeys as $key => $value) {
            if (!in_array($key, $skipKeys)) {
                $parameters .= '&' . urlencode($key) . '=' . urlencode($value);
                $numOfAddedParameters++;
            }
        }

        // Base URL is https://counts.secondyear.com.au[/:controller[/:action[/:params]]]?
        // It's basically everything _BUT_ $_GET parameters
        //$baseUrl = $this->url->getBaseUri() . ltrim($getKeys['_url'], '/');
        $baseUrl = isset($getKeys['_url']) ? $this->url->getBaseUri() . ltrim($getKeys['_url'], '/') : $this->url->getBaseUri();

        $completeUrl = $baseUrl;
        if ($numOfAddedParameters > 0) {
            $completeUrl .= '?' . ltrim($parameters, '&');
        }

        $this->view->setVar('_url', [
            'amountOfGetParams' => $numOfAddedParameters,
            'baseUrl' => $baseUrl,
            'completeUrl' => $completeUrl,
            'searchUrl' => str_replace('/search', '', $baseUrl),
        ]);

    }

}
