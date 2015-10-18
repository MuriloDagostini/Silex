<?php

require_once __DIR__ . "/../bootstrap.php";

use Symfony\Component\HttpFoundation\Response;

$response = new Response();

$app->get('/',function() use ($response){

    $response->setContent("Olá mundo!");

    return $response;

});

$app->get('/clientes',function() use ($response){

    $clientes = [
        ['nome'=>"Maria",'email'=>'maria@gmail.com','cpf_cnpj'=>'888.777.444-44'],
        ['nome'=>"João",'email'=>'joao@gmail.com','cpf_cnpj'=>'555.333.444-44'],
        ['nome'=>"Claudio",'email'=>'claudio@gmail.com','cpf_cnpj'=>'222.111.444-44'],
    ];

    $response->setContent(json_encode($clientes));

    return $response;

});

$app->run();