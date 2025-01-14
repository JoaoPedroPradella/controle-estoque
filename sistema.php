<?php

declare(strict_types=1);


use App\Models\Usuario;

session_set_cookie_params(['httponly' => true]);

session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets\css\sistema.css">
        <title>Menu</title>
</head>
<button id="sair" onclick="deslogar()">Sair</button>
<h1>Bem-vindo <?php echo $_SESSION['nome'] ?> </h1>

<body>
        <table>
                <tr class="row">
                        <td><a href="cad-cliente.php"><button><img src="assets\img\customer.png" alt="cliente">Clientes</button></a></td>
                        <td><a href="cad-item.php"><button><img src="assets\img\product.png" alt="cliente">Estoque</button></a></td>
                </tr>
                <tr class="row">
                        <td><a href="cad-venda.php"><button><img src="assets\img\pdv.png" alt="cliente">PDV</button></a></td>
                        <td><a href="cad-usuario.php"><button><img src="assets\img\user.png" alt="cliente">Usuários</button></a></td>
                </tr>
        </table>
</body>
<script src="assets\js\jquery.js"></script>
<script src="assets\js\usuario.js"></script>
</html>