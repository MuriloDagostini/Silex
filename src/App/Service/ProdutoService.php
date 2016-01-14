<?php

namespace App\Service;

use App\Entity\Produto;
use App\Mapper\ProdutoMapper;

class ProdutoService
{
    private $produto;
    private $produtoMapper;

    public function __construct(Produto $produto, ProdutoMapper $produtoMapper)
    {
        $this->produto = $produto;
        $this->produtoMapper = $produtoMapper;
    }

    public function insert(array $dados){

        $produtoEntity = $this->produto;
        $produtoEntity->setNome($dados['nome']);
        $produtoEntity->setDescricao($dados['descricao']);
        $produtoEntity->setValor($dados['valor']);

        $mapper = $this->produtoMapper;
        $result = $mapper->insert($produtoEntity);

        return $result;

    }

    public function update(array $dados){

        $produtoEntity = $this->produto;
        $produtoEntity->setId($dados['id']);
        $produtoEntity->setNome($dados['nome']);
        $produtoEntity->setDescricao($dados['descricao']);
        $produtoEntity->setValor($dados['valor']);

        $mapper = $this->produtoMapper;
        $result = $mapper->update($produtoEntity);

        return $result;

    }

    public function delete(array $dados){

        $produtoEntity = $this->produto;
        $produtoEntity->setId($dados['id']);

        $mapper = $this->produtoMapper;
        $result = $mapper->delete($produtoEntity);

        return $result;

    }

    public function getProdutos(){

        $mapper = $this->produtoMapper;
        $result = $mapper->getProdutos();

        return $result;

    }
}