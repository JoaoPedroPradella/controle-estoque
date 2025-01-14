<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Pagamento;

header('Content-Type: application/json');

$id = isset($_POST['txtid'])  ? $_POST['txtid']     : '';
$desc = isset($_POST['txtdesc'])  ? $_POST['txtdesc']     : '';


if ($id == '' || $desc == '') {
    echo json_encode('Existem campos vazios. Verifique!');
    exit;
}

$bd = new BancoDeDados();
$pag = new Pagamento($bd);

try {
    echo json_encode($pag->cadastrar($id, $desc));
} catch (Exception $e) {
    // Captura exceções e retorna o erro
    echo json_encode(['erro' => $e->getMessage()]);
}
