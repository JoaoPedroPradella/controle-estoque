<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Usuario;

$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($id == '') {
    echo json_encode(['erro' => 'ID não econtrado']);
    exit();
}

$bd = new BancoDeDados;
$usuario = new Usuario($bd);

try {
    echo json_encode($usuario->excluir($id));
} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
