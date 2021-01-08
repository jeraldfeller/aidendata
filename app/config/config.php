<?php

return new \Phalcon\Config([
    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'aiden_user',
        'password' => 'Sa2hw.*&}[Mh',
        'name' => 'aidendat_pdf',
    ],
    'application' => [
        'title' => 'PDF Crawler',
        'baseUri' => 'https://aidendata.com/', // End with /
        'curlUserAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36',
        'curlTimeout' => 300, // How long before a page times out
        'dev' => true, // Development mode, used for cURL VERIFYPEER & VERIFYHOST flags and VOLT-compiler compileAlways flag
        'mailgunApiKey' => 'key-f273abea1f32dd2f86ffa9e1b8359a3a',
        'mailgunDomain' => 'mailgun.aidendata.com',
        'mailFromName' => 'Aiden',
        'mailFromEmail' => 'aiden@aidendata.com',
        'mailDigestSubject' => 'PDF Digest for ' . date('d F Y'),
        /**
         * skipExistingPdfUrls:
         * If true the crawler will not add PDF URLs to the database that have already been
         * added as PDFs. This will save time as the crawler won't have to redownload each
         * PDF on every crawl, but the crawler will not be able to check if a PDF changed.
         * I recommend to leave it on false unless it eats too much bandwidth.
         *
         */
        'skipExistingPdfUrls' => false,
        'scrapeSourcesHourDifference' => 24, // How many hours between scrapes?
        'amountOfUrlsPerScrape' => 1,
        'maxItemsPerPage' => 25,
        'maxConcurrentRequests' => 5,
        'directories' => [
            'compiledDir' => __DIR__ . '/../../app/compiled/',
            'controllersDir' => __DIR__ . '/../../app/controllers/',
            'modelsDir' => __DIR__ . '/../../app/models/',
            'classesDir' => __DIR__ . '/../../app/classes/',
            'viewsDir' => __DIR__ . '/../../app/views/',
            'formsDir' => __DIR__ . '/../../app/forms/',
            'cookiesDir' => __DIR__ . '/../../app/cookies/',
            'logsDir' => __DIR__ . '/../../app/logs/',
            'pdfsDir' => __DIR__ . '/../../app/pdfs/',
        ],
    ]
]);




