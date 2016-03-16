<?php
require_once __DIR__ . "/../bootstrap.php";

use App\Service\ProdutoService;
use App\Entity\Produto;
use App\Mapper\ProdutoMapper;
use App\DB\ConexaoDB;
use App\DB\Fixture;
use Symfony\Component\HttpFoundation\Request;

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

/**
 *  API PUBLICA
 */

//LISTAR PRODUTOS
$app->get('/api/produtos',function() use ($app){

    $dados = $app['produtoService']->getProdutos();

    if($dados){
        return $app->json($dados);
    }else{
        return $app->json('Nenhum produto cadastrado');
    }

});

//LISTAR UM PRODUTO
$app->get('/api/produto/{id}',function($id) use ($app){

    if(!filter_var($id,FILTER_VALIDATE_INT) === false){

        $dados = $app['produtoService']->getProduto($id);

        if($dados){
            return $app->json($dados);
        }else{
            return $app->json('Produto não encontrado');
        }

    }else{
        return $app->json('Input inválido',500);
    }

});

$app->post('/api/produto/insert',function(Request $request) use ($app){

    $dados['nome'] = filter_var($request->get('nome'),FILTER_SANITIZE_STRING);
    $dados['descricao'] = filter_var($request->get('descricao'),FILTER_SANITIZE_STRING);
    $dados['valor'] = filter_var($request->get('valor'),FILTER_SANITIZE_NUMBER_FLOAT);

    if(!$dados['nome']){
        return $app->json('nome inválido',500);
    }
    if(!$dados['descricao']){
        return $app->json('decrição inválida',500);
    }
    if(!$dados['valor']){
        return $app->json('valor inválido',500);
    }

    $app['produtoService']->insert($dados);

    return $app->json('Produto inserido com sucesso');

});

$app->put('/api/produto/update',function(Request $request) use ($app){

    $dados['id'] = filter_var($request->get('id_produto'),FILTER_VALIDATE_INT);
    $dados['nome'] = filter_var($request->get('nome'),FILTER_SANITIZE_STRING);
    $dados['descricao'] = filter_var($request->get('descricao'),FILTER_SANITIZE_STRING);
    $dados['valor'] = filter_var($request->get('valor'),FILTER_SANITIZE_NUMBER_FLOAT);

    if(!$dados['id']){
        return $app->json('id_produto inválido',500);
    }
    if(!$dados['nome']){
        return $app->json('nome inválido',500);
    }
    if(!$dados['descricao']){
        return $app->json('decrição inválida',500);
    }
    if(!$dados['valor']){
        return $app->json('valor inválido',500);
    }

    if($app['produtoService']->update($dados)){
        return $app->json('Produto alterado com sucesso');
    }else{
        return $app->json('Produto não encontrado');
    }

});

$app->delete('/api/produto/delete',function(Request $request) use ($app){

    $dados['id'] = filter_var($request->get('id_produto'),FILTER_VALIDATE_INT);

    if(!$dados['id']){
        return $app->json('id_produto inválido',500);
    }

    if($app['produtoService']->delete($dados)){
        return $app->json('Produto excluído com sucesso');
    }else{
        return $app->json('Produto não encontrado');
    }


});

$app->run();