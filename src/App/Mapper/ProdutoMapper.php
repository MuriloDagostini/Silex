<?php

namespace App\Mapper;

use App\DB\ConexaoDB;
use App\Entity\Produto;

class ProdutoMapper
{
    public function insert(Produto $produto){

        $DB = new ConexaoDB();

        $sql = "insert into produto (nome, descricao, valor) VALUES (:nome,:descricao,:valor)";
        $stmt = $DB->conexao->prepare($sql);
        $stmt->bindValue("nome",$produto->getNome());
        $stmt->bindValue("descricao",$produto->getDescricao());
        $stmt->bindValue("valor",$produto->getValor());

        return $stmt->execute();
    }

    public function update(Produto $produto){

        $DB = new ConexaoDB();

        $sql = "UPDATE produto SET nome = :nome, descricao = :descricao, valor = :valor WHERE id_produto = :id_produto";
        $stmt = $DB->conexao->prepare($sql);
        $stmt->bindValue("id_produto",$produto->getId());
        $stmt->bindValue("nome",$produto->getNome());
        $stmt->bindValue("descricao",$produto->getDescricao());
        $stmt->bindValue("valor",$produto->getValor());

        return $stmt->execute();
    }

    public function delete(Produto $produto){
        $DB = new ConexaoDB();

        $sql = "DELETE FROM produto WHERE id_produto = :id_produto";
        $stmt = $DB->conexao->prepare($sql);
        $stmt->bindValue("id_produto",$produto->getId());

        return $stmt->execute();
    }

    public function getProdutos(){

        $DB = new ConexaoDB();

        $sql = "SELECT * FROM produto ";
        $stmt = $DB->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();

    }

}