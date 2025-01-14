<?php

declare(strict_types=1);

namespace App\Models;

use DomainException;
use PDOException;
use Exception;
use PDO;

class BancoDeDados
{
    private $conexao;
    private $server = 'localhost';
    private $user = 'postgres';
    private $password = '123';
    private $port = '5433';

    public function __construct()
    {
        try {
            // Conexão usando DSN no formato correto para PostgreSQL com PDO
            $dsn = "pgsql:host=$this->server;port=$this->port;dbname=postgres;";
            $this->conexao = new PDO($dsn, $this->user, $this->password);
            // Configura o PDO para lançar exceções em caso de erro
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $erro) {
            throw new Exception("Não foi possível conectar ao servidor PostGreSQL" . $erro->getMessage());
        }
    }

    public function executarComando($sql, $parametros = [])
    {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($parametros);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    public function selecionarRegistro($sql, $parametros = [])
    {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($parametros);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    public function selecionarRegistros($sql, $parametros = [])
    {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    public function desconectar()
    {
        $this->conexao = null;
    }
}
