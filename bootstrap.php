<?php

require_once 'vendor/autoload.php';

date_default_timezone_set ('America/Sao_Paulo');
$app = new \Silex\Application();

$app['debug'] = true;