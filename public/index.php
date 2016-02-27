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

$app->get('/',function() use ($app){

    $dados = $app['produtoService']->getProdutos();

    $vars = [
        'produtos' => $dados
    ];

    return $app['twig']->render('index.twig',$vars);

})->bind('produto_list');

$app->get('/fixture',function() use ($app){
    $app['fixtureService']->CreateDB();
    return "";
});

$app->get('/produto/add',function() use ($app){

    $vars = [

    ];

    return $app['twig']->render('/produto/add.twig',$vars);

})->bind('produto_add');

$app->post('/produto/insert',function() use ($app){

    $dados['nome'] = $_POST['nome'];
    $dados['descricao'] = $_POST['descricao'];
    $dados['valor'] = $_POST['valor'];

    $app['produtoService']->insert($dados);

    echo "<script>alert('Produto inserido');window.location.href = '/';</script>";

    return '';

})->bind('produto_insert');

$app->get('/produto/alter',function() use ($app){

    $id_produto = $_GET['id_produto'];

    $dados = $app['produtoService']->getProduto($id_produto);

    $vars = [
        'dados' => $dados
    ];

    return $app['twig']->render('/produto/add.twig',$vars);

})->bind('produto_alter');

$app->post('/produto/update',function() use ($app){

    $dados['id'] = $_POST['id_produto'];
    $dados['nome'] = $_POST['nome'];
    $dados['descricao'] = $_POST['descricao'];
    $dados['valor'] = $_POST['valor'];

    $app['produtoService']->update($dados);

    echo "<script>alert('Produto atualizado');window.location.href = '/';</script>";

    return '';

})->bind('produto_update');

$app->get('/produto/delete',function() use ($app){

    $dados['id'] = $_GET['id_produto'];

    $app['produtoService']->delete($dados);

    echo "<script>alert('Produto excluído');window.location.href = '/';</script>";

    return '';

})->bind('produto_delete');

$app->run();