<?php

namespace App\Mapper;

use App\DB\ConexaoDB;
use App\Entity\Produto;

class ProdutoMapper
{
    protected $DB;

    public function __construct(ConexaoDB $DB)
    {
        $this->DB = $DB;
    }

    public function insert(Produto $produto){

        $sql = "insert into produto (nome, descricao, valor) VALUES (:nome,:descricao,:valor)";
        $stmt = $this->DB->conexao->prepare($sql);
        $stmt->bindValue("nome",$produto->getNome());
        $stmt->bindValue("descricao",$produto->getDescricao());
        $stmt->bindValue("valor",$produto->getValor());

        return $stmt->execute();
    }

    public function update(Produto $produto){

        $sql = "UPDATE produto SET nome = :nome, descricao = :descricao, valor = :valor WHERE id_produto = :id_produto";
        $stmt = $this->DB->conexao->prepare($sql);
        $stmt->bindValue("id_produto",$produto->getId());
        $stmt->bindValue("nome",$produto->getNome());
        $stmt->bindValue("descricao",$produto->getDescricao());
        $stmt->bindValue("valor",$produto->getValor());

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(Produto $produto){

        $sql = "DELETE FROM produto WHERE id_produto = :id_produto";
        $stmt = $this->DB->conexao->prepare($sql);
        $stmt->bindValue("id_produto",$produto->getId());

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function getProdutos(){

        $sql = "SELECT * FROM produto ";
        $stmt = $this->DB->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();

    }

    public function getProduto($id_produto){

        $sql = "SELECT * FROM produto where id_produto = :id_produto ";
        $stmt = $this->DB->conexao->prepare($sql);
        $stmt->bindValue("id_produto",$id_produto);
        $stmt->execute();

        return $stmt->fetch();

    }

}