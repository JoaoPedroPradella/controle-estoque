<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Cliente;

header('Content-Type: application/json');

$id = isset($_POST['txtid'])  ? $_POST['txtid']     : '';
$form['nome'] = isset($_POST['txtnome'])  ? $_POST['txtnome']     : '';
$form['cpf'] = isset($_POST['txtcpf'])  ? $_POST['txtcpf']     : '';
$form['tel'] = isset($_POST['txttel'])  ? $_POST['txttel']     : '';
$form['uf'] = isset($_POST['txtuf'])  ? $_POST['txtuf']     : '';
$form['munic'] = isset($_POST['txtmunic'])  ? $_POST['txtmunic']     : '';
$form['cep'] = isset($_POST['txtcep'])  ? $_POST['txtcep']     : '';


if ($id == '' || in_array('', $form)) {
    echo json_encode('Existem campos vazios. Verifique!');
    exit;
}

$bd = new BancoDeDados();
$novoCliente = new cliente($bd);

try {
    echo json_encode($novoCliente->cadastrar($id, $form));
} catch (Exception $e) {
    // Captura exceções e retorna o erro
    echo json_encode(['erro' => $e->getMessage()]);
}
