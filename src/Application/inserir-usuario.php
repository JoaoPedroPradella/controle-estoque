<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Usuario;

header('Content-Type: application/json');

$id = isset($_POST['txtid'])  ? $_POST['txtid']     : '';
$form['nome'] = isset($_POST['txtnome'])  ? $_POST['txtnome']     : '';
$form['email'] = isset($_POST['txtemail'])  ? $_POST['txtemail']     : '';
$form['senha'] = isset($_POST['txtsenha'])  ? $_POST['txtsenha']     : '';


if ($id == '' || in_array('', $form)) {
    echo json_encode('Existem campos vazios. Verifique!');
    exit;
}

// Verificando se é um e-mail válido
if (Usuario::validarEmail($form['email'])) {
    echo json_encode(['erro' => 'Esse e-mail não é um e-mail válido!']);
    exit;
}

$bd = new BancoDeDados();
$sql = 'SELECT email FROM usuario 
WHERE email = ?';
$params = [$form['email']];
$dados = $bd->selecionarRegistro($sql, $params);

if (!$dados == '') {
    echo json_encode(['erro' => 'E-mail já utilizado!']);
    exit;
}

$usuario = new Usuario($bd);

try {
    echo json_encode($usuario->cadastrar($id, $form));
} catch (Exception $e) {
    // Captura exceções e retorna o erro
    echo json_encode(['erro' => $e->getMessage()]);
}
