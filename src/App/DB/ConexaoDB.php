<?php

namespace App\DB;

use PDO;

class ConexaoDB
{
    // Guarda a conexao ate a pagina ser reaberta
    public $conexao;

    function __construct()
    {
        try {
            $config = include "config.php";
            $host = (isset($config['db']['host'])) ? $config['db']['host'] : null;
            $dbname = (isset($config['db']['dbname'])) ? $config['db']['dbname'] : null;
            $user = (isset($config['db']['user'])) ? $config['db']['user'] : null;
            $password = (isset($config['db']['password'])) ? $config['db']['password'] : null;

            $this->conexao = new \PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        } catch (\PDOException $e) {
            die("Erro código: " . $e->getCode() . ": " . $e->getMessage());
        }

    }

}