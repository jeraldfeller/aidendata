<?php

$loader = new \Phalcon\Loader();
$loader->registerNamespaces([
    'Aiden\Controllers' => __DIR__ . '/../controllers/',
    'Aiden\Forms' => __DIR__ . '/../forms/',
    'Aiden\Models' => __DIR__ . '/../models/',
    'Aiden\Classes' => __DIR__ . '/../classes/',
    "Smalot\PdfParser" => $config->application->directories->classesDir . 'PdfParser/',
    "Smalot\PdfParser\Element" => $config->application->directories->classesDir . 'PdfParser/Element/',
    "Smalot\PdfParser\Encoding" => $config->application->directories->classesDir . 'PdfParser/Encoding/',
    "Smalot\PdfParser\Font" => $config->application->directories->classesDir . 'PdfParser/Font/',
    "Smalot\PdfParser\Tests" => $config->application->directories->classesDir . 'PdfParser/Tests/',
    "Smalot\PdfParser\Tests\Units" => $config->application->directories->classesDir . 'PdfParser/Tests/Units/',
    "Smalot\PdfParser\XObject" => $config->application->directories->classesDir . 'PdfParser/Tests/XObject/',
    "Purl" => $config->application->directories->classesDir . 'Purl/',
]);
$loader->registerClasses([
    "phpUri" => $config->application->directories->classesDir . 'phpuri.php',
    "TCPDF" => $config->application->directories->classesDir . 'TCPDF-master/tcpdf.php',
    "TCPDF_PARSER" => $config->application->directories->classesDir . 'TCPDF-master/tcpdf_parser.php',
]);
$loader->register();
