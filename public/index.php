<?php

error_reporting(E_ALL);
ini_set('memory_limit', '2048M');
ini_set('set_time_limit', 300);
try {

    /**
     * Read the configuration
     */
    $config = require __DIR__ . "/../app/config/config.php";

    /**
     * Include loader
     */
    require __DIR__ . '/../app/config/loader.php';

    /**
     * Include services
     */
    require __DIR__ . '/../app/config/services.php';
    
    require __DIR__ . '/../app/classes/simple_html_dom.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    echo $application->handle()->getContent();
} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}