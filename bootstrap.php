<?php

require_once 'vendor/autoload.php';

date_default_timezone_set ('America/Sao_Paulo');
$app = new \Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(),array(
    'twig.path' => __DIR__.'\src\App\Views'
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());