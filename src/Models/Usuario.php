<?php

declare(strict_types=1);

namespace App\Models;

use DomainException;
use App\Models\BancoDeDados;

class Usuario
{

    private BancoDeDados $bd;


    public function __construct(BancoDeDados $bd)
    {
        $this->bd = $bd;
    }
    public function cadastrar(string $id, array $form): string
    {
        if ($id == 'NOVO') {
            $sql = 'INSERT INTO usuario (nome, email, senha) VALUES
            (?, ?, ?)';
            $params = [
                $form['nome'],
                $form['email'],
                $form['senha']
            ];
            $msg = 'Usuario cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE usuario SET nome=?, email=?, senha=?  
            WHERE id = ?;';
            $params = [
                $form['nome'],
                $form['email'],
                $form['senha'],
                $id
            ];
            $msg = 'Usuario alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listar(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT id, nome, email, senha FROM usuario';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT id, nome, email, senha FROM usuario WHERE id = ?';
        $params = [$id];
        $dados = $this->bd->selecionarRegistro($sql, $params);

        if (!empty($dados)) {
            // Retorne os dados como JSON válido
            return ($dados);
        } else {
            // Retorne uma mensagem de erro como JSON
            $msg = ('Registro não encontrado');
            return $msg;
        }
    }

    public function excluir(string $id): string
    {
        $sql = 'DELETE FROM usuario WHERE id = ?';
        $params = [$id];
        $this->bd->executarComando($sql, $params);
        return 'Usuário excluido com sucesso!';
    }

    public static function validarEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            exit();
        }
        return false;
    }

    public static function login(string $email, string $senha): void
    {
        $bd = new BancoDeDados;
        $sql = 'SELECT id, nome FROM usuario
        WHERE email = ? AND senha = ?';
        $params = [$email, $senha];
        $dados = $bd->selecionarRegistro($sql, $params);

        if ($dados['id'] == null) {
            echo   "<script>
                        alert('E-mail ou senha inválidos!')
                        window.location.href = '../../index.php'
                    </script>";

            exit();
        } else {
            session_set_cookie_params(['httponly' => true]);
            session_start();
            session_regenerate_id(true);

            $_SESSION['id'] = $dados['id'];
            $_SESSION['nome'] = $dados['nome'];

            header('LOCATION: ../../sistema.php');
            exit();
        }
    }

    public static function deslogar(): void
    {
        session_start();
        session_destroy();
    }
}
