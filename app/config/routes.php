<?php

$router = new Phalcon\Mvc\Router(false);

$router->add('/:controller/:action/:params', [
    'namespace' => 'Aiden\Controllers',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
]);

$router->add('/', [
    'namespace' => 'Aiden\Controllers',
    'controller' => 'index',
    'action' => 'index',
]);

$router->add('/:controller', [
    'namespace' => 'Aiden\Controllers',
    'controller' => 1
]);

return $router;
