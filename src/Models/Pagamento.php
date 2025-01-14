<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;

class Pagamento
{
    private BancoDeDados $bd;

    // Injeção de dependência para a classe BancoDeDados
    public function __construct(BancoDeDados $bd)
    {
        $this->bd = $bd;
    }

    public function cadastrar(string $id, string $desc): string
    {
        if ($id == 'NOVO') {
            $sql = 'INSERT INTO pagamento (descricao) VALUES
            (?)';
            $params = [$desc];
            $msg = 'Pagamento cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE pagamento SET descricao=?
            WHERE id = ?;';
            $params = [
                $desc,
                $id,
            ];
            $msg = 'Pagamento alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listar(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT id, descricao FROM pagamento';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT id, descricao FROM pagamento WHERE id = ?';
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
        $sql = 'SELECT count(pagamentoid) AS pagamento FROM venda WHERE pagamentoid = ?';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);

        if($resposta['pagamento'] == 0){
            $sql = 'DELETE FROM pagamento WHERE id = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Pagamento excluido com sucesso!';
        }else{
            return 'Pagamento já em uso em vendas!';
            exit();
        }

    }
}
