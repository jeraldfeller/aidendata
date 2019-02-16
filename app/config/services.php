<?php

$di = new \Phalcon\DI\FactoryDefault();
$di->set('config', function() use ($config) {
    return $config;
});
$di->setShared('router', function () {
    return require __DIR__ . '/routes.php';
});
$di->set('url', function() use ($config) {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});
$di->set('dispatcher', function () {

    $eventsManager = new \Phalcon\Events\Manager();
    $eventsManager->attach('dispatch:beforeDispatch', new \Aiden\Classes\SecurityPlugin());
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});
$di->set('view', function() use ($config) {

    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir($config->application->directories->viewsDir);

    $volt = function($view, $di) use ($config) {

        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
        $volt->setOptions(array(
            'compileAlways' => true, // Development only
            'compiledPath' => $config->application->directories->compiledDir,
        ));

        $compiler = $volt->getCompiler();
        $compiler->addFunction('in_array', 'in_array');
        $compiler->addFunction('strtotime', 'strtotime');
        $compiler->addFunction('round', 'round');
        $compiler->addFunction('basename', 'basename');
        $compiler->addFunction("parseMySqlDateTime", function ($resolvedArgs, $exprArgs) {
            return '\DateTime::createFromFormat("Y-m-d H:i:s", ' . $resolvedArgs . ')';
        });

        return $volt;
    };

    $view->registerEngines(['.volt' => $volt]);
    return $view;
});
$di->set('db', function() use ($config) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name
    ));
});
$di->setShared('session', function() {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
});
$di->set('flashSession', function () {

    $flashSession = new \Phalcon\Flash\Session([
        'error' => '',
        'success' => '',
        'notice' => '',
        'warning' => '',
    ]);

    return $flashSession;
});
$di->set('logger', function() use ($config) {

    $logName = date('Y-m-d') . '.log';
    $logPath = $config->application->directories->logsDir . $logName;
    $logger = new \Phalcon\Logger\Adapter\File($logPath);
    return $logger;
});
$di->set('modelsManager', function() use ($config) {
    return new \Phalcon\Mvc\Model\Manager();
});
