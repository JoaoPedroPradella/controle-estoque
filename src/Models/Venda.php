<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;
use Exception;

class Venda
{
    private BancoDeDados $bd;

    // Injeção de dependência para a classe BancoDeDados
    public function __construct(BancoDeDados $bd)
    {
        $this->bd = $bd;
    }

    public function cadastrar(array $form, array $dadosItens): string
    {
        // Vamos precisar somente do id, de itens, cliente e pagamentos

        $sql = 'INSERT INTO venda (datahora, valortotal, clienteid, pagamentoid) VALUES
            (CURRENT_TIMESTAMP, ?, ?, ?)';
        $params = [
            $form['valTotal'],
            $form['clienteID'],
            $form['pagID'],
        ];

        $this->bd->executarComando($sql, $params);

        $sql = 'SELECT MAX(numvenda) FROM venda';


        $dados = $this->bd->selecionarRegistros($sql);

        $numVenda = $dados[0]['max'] ?? null;
        if (!$numVenda) {
            throw new Exception('Erro ao obter o número da venda.');
        }

        foreach ($dadosItens as $item) {
            $sql = 'INSERT INTO prod_venda (precounit, quantidade, produtoid, vendaid) VALUES (?, ?, ?, ?)';

            $params = [
                $item['prec'],  // Preço do item
                $item['qtd'],  // Quantidade do item
                $item['idItem'],  // Código do item
                $numVenda,
            ];

            $this->bd->executarComando($sql, $params);
        }

        foreach ($dadosItens as $item) {
            $sql = 'UPDATE produto SET quantidade= quantidade - ? WHERE id=?';

            $params = [
                $item['qtd'],  // Quantidade do item
                $item['idItem'],  // Código do item
            ];

            $this->bd->executarComando($sql, $params);
        }

        $msg = 'Venda cadastrada com sucesso!';


        return $msg;
    }

    public function listar(string $id, string $tipo): mixed
    {

        if (!$tipo == '') {
            $sql = "SELECT v.numvenda as numero, c.nome as cliente, v.valortotal, p.descricao as pagameto, TO_CHAR(v.datahora, 'DD/MM/YYYY HH24:MI:SS') as data	FROM venda v
            inner join cliente c 
            on v.clienteid = c.id
            inner join pagamento p
            on v.pagamentoid = p.id";
            $dados = $this->bd->selecionarRegistros($sql);

            return ($dados);

            exit;
        }
        //var_dump($id);
        $sql = 'SELECT pd.precounit, pd.quantidade, p.descricao
        FROM venda v
        INNER JOIN prod_venda pd
        ON v.numvenda = pd.vendaid
        INNER JOIN produto p
        ON pd.produtoid = p.id
        WHERE numvenda = ?';
        $params = [
            $id
        ];
        $dados[] = $this->bd->selecionarRegistros($sql, $params);

        $sql = 'SELECT v.numvenda, v.valortotal, c.nome AS cliente,pag.descricao AS pagamento
        FROM venda v
        INNER JOIN cliente c
        ON v.clienteid = c.id
        INNER JOIN pagamento pag
        ON v.pagamentoid = pag.id
        WHERE numvenda = ?';
        $params = [
            $id
        ];
        $dados[] = $this->bd->selecionarRegistro($sql, $params);

        //var_dump($dados);
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
        $sql = 'DELETE FROM prod_venda WHERE id IN(SELECT p.id FROM venda v 
        INNER JOIN prod_venda p
        ON v.numvenda = p.vendaid
        WHERE v.numvenda = ?)';
        $params = [
            $id
        ];
        $this->bd->executarComando($sql, $params);

        $sql = 'DELETE FROM venda WHERE numvenda = ?';
        $params = [$id];
        $this->bd->executarComando($sql, $params);

        return 'Venda excluida com sucesso!';
    }
}
