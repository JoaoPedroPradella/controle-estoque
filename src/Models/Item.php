<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;

class Item
{
    private BancoDeDados $bd;

    // Injeção de dependência para a classe BancoDeDados
    public function __construct(BancoDeDados $bd)
    {
        $this->bd = $bd;
    }

    public function cadastrar(string $id, array $form): string
    {
        if ($id == 'NOVO') {
            $sql = 'INSERT INTO produto (descricao, preco, quantidade) VALUES
            (?, ?, ?)';
            $params = [
                $form['desc'],
                $form['preco'],
                $form['qtd'],
            ];
            $msg = 'Produto cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE produto SET descricao=?, preco=?, quantidade=?  
            WHERE id = ?;';
            $params = [
                $form['desc'],
                $form['preco'],
                $form['qtd'],
                $id,
            ];
            $msg = 'Produto alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listar(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT id, descricao, preco, quantidade FROM produto';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT id, descricao, preco, quantidade FROM produto WHERE id = ?';
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
        $sql = 'SELECT count(produtoid) AS produto FROM prod_venda WHERE produtoid = ?';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);

        if ($resposta['produto'] == 0) {
            $sql = 'DELETE FROM produto WHERE id = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Produto excluido com sucesso!';
        } else {
            return 'Produto já em uso em vendas!';
            exit();
        }
    }
}
