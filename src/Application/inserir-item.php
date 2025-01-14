<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Item;

header('Content-Type: application/json');

$id = isset($_POST['txtid'])  ? $_POST['txtid']     : '';
$form['desc'] = isset($_POST['txtdesc'])  ? $_POST['txtdesc']     : '';
$form['preco'] = isset($_POST['txtpreco'])  ? $_POST['txtpreco']     : '';
$form['qtd'] = isset($_POST['txtqtd'])  ? $_POST['txtqtd']     : '';


if ($id == '' || in_array('', $form)) {
    echo json_encode('Existem campos vazios. Verifique!');
    exit;
}

$bd = new BancoDeDados();
$item = new Item($bd);

try {
    echo json_encode($item->cadastrar($id, $form));
} catch (Exception $e) {
    // Captura exceções e retorna o erro
    echo json_encode(['erro' => $e->getMessage()]);
}
