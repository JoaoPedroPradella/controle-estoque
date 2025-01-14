<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Item;

$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($id == '') {
    echo json_encode(['erro' => 'ID não econtrado']);
    exit();
}

$bd = new BancoDeDados;
$item = new Item($bd);

try {
    echo json_encode($item->excluir($id));
} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
