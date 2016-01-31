<?php
require_once __DIR__ . "/../bootstrap.php";

use App\Service\ProdutoService;
use App\Entity\Produto;
use App\Mapper\ProdutoMapper;
use App\DB\ConexaoDB;
use App\DB\Fixture;

$app['produtoService'] = function(){
    $produto = new Produto();
    $produtoMapper = new ProdutoMapper();
    $produtoService = new ProdutoService($produto,$produtoMapper);

    return $produtoService;
};

$app['fixtureService'] = function(){
    $conexao = new ConexaoDB();
    $fixture = new Fixture($conexao);

    return $fixture;
};

$app->get('/',function(){
    return "Início";
});

$app->get('/fixture',function() use ($app){
    $app['fixtureService']->CreateDB();
    return "";
});

$app->get('/produto/insert',function() use ($app){

    $dados['nome'] = "ASUS ZENBOOK UX31A";
    $dados['descricao'] = "Uma breve descrição sobre o produto";
    $dados['valor'] = "1799.00";

    $result = $app['produtoService']->insert($dados);

    return $app->json($result);

});

$app->get('/produto/update',function() use ($app){

    $dados['id'] = "2";
    $dados['nome'] = "ASUS ZENBOOK UX31A";
    $dados['descricao'] = "Uma breve descrição sobre o produto";
    $dados['valor'] = "1999.00";

    $result = $app['produtoService']->update($dados);

    return $app->json($result);

});

$app->get('/produto/delete',function() use ($app){

    $dados['id'] = "2";

    $result = $app['produtoService']->delete($dados);

    return $app->json($result);

});

$app->get('/produto/list',function() use ($app){

    $result = $app['produtoService']->getProdutos();

    return $app->json($result);

});

$app->run();