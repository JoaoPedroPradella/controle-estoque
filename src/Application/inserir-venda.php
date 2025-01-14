<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Venda;

header('Content-Type: application/json');

$itens = isset($_POST['objItens'])  ? $_POST['objItens']     : '';
$form['cliente'] = isset($_POST['txtcliente'])  ? $_POST['txtcliente']     : '';
$form['clienteID'] = isset($_POST['txtclienteID'])  ? $_POST['txtclienteID']     : '';
$form['pag'] = isset($_POST['txtpag'])  ? $_POST['txtpag']     : '';
$form['pagID'] = isset($_POST['txtpagID'])  ? $_POST['txtpagID']     : '';
$form['valTotal'] = isset($_POST['txttotal'])  ? $_POST['txttotal']     : '';

$dadosItens = json_decode($itens, true);

if (empty($dadosItens)) {
    echo json_encode(['erro' => 'Não é possível cadastrar uma venda sem itens!']);
    exit;
}

if (in_array('', $form)) {
    echo json_encode('Existem campos vazios. Verifique!');
    exit;
}

$bd = new BancoDeDados();
$novaVenda = new Venda($bd);

try {
    echo json_encode($novaVenda->cadastrar($form, $dadosItens));
} catch (Exception $e) {
    // Captura exceções e retorna o erro
    echo json_encode(['erro' => $e->getMessage()]);
}
