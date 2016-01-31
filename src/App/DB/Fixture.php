<?php

namespace App\DB;

class Fixture
{
    private $DB;

    function __construct($DB)
    {
        $this->DB = $DB;
    }

    public function CreateDB(){

        echo "### Executando Fixture ### <br>";

        $DB = $this->DB;

        echo "Removendo tabela produto <br>";
        $DB->conexao->query("DROP TABLE IF EXISTS produto;");
        echo " - OK <br>";

        echo "Criando tabela produto <br>";
        $DB->conexao->query("CREATE TABLE produto (
          id_produto INT NOT NULL AUTO_INCREMENT,
          nome VARCHAR(120) CHARACTER SET 'utf8' NULL,
          descricao TEXT CHARACTER SET 'utf8' NULL,
          valor DECIMAL (10,2) NULL,
          PRIMARY KEY (id_produto));");

        echo "Inserindo produto <br>";
        $stmt = $DB->conexao->prepare("INSERT INTO produto (nome,descricao,valor) VALUE (
          'Produto Teste',
          'Breve descrição sobre o produto teste',
          100.00
          );");
        echo $stmt->queryString;
        $stmt->execute();
        echo " - OK <br>";

        echo "### Fixture Executada ###";
    }
}

