<?php

namespace App\Mapper;

use App\Entity\Produto;

class ProdutoMapper
{
    public function insert(Produto $produto){
        return ['Insert',$produto->getNome(),$produto->getDescricao(),$produto->getValor()];
    }

    public function update(Produto $produto){
        return ['Update',$produto->getId(),$produto->getNome(),$produto->getDescricao(),$produto->getValor()];
    }

    public function delete(Produto $produto){
        return ['Delete',$produto->getId()];
    }

    public function getProdutos(){
        return [
                ['1','Notebook Asus','Uma breve descrição sobre o produto','1.799,00'],
                ['2','Notebook Asus','Uma breve descrição sobre o produto','1.799,00'],
                ['3','Notebook Asus','Uma breve descrição sobre o produto','1.799,00'],
                ['4','Notebook Asus','Uma breve descrição sobre o produto','1.799,00'],
               ];
    }

}