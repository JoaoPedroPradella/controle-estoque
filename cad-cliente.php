<?php

session_set_cookie_params(['httponly' => true]);
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets\css\cadastros.css">
    <title>Clientes</title>
</head>

<main>
    <div class="cabecalho">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <h1 class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                </svg>
                <span class="fs-4">Lista de Clientes</span>
            </h1>

            <ul class="nav nav-pills">
                <li class="nav-item"><button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="voltarPag()">Menu</button></li>
            </ul>
        </header>
    </div>
</main>

<table>
    <thead>
        <tr>
            <th id="codigo">Código</th>
            <th id="nome">Nome</th>
        </tr>
    </thead>
    <tbody id="lista">
        <!-- Linhas serão adicionadas dinamicamente aqui -->
    </tbody>
</table>

<button class="mb-2 btn btn-lg rounded-3 btn-primary" onclick="novoCliente()" id="Novo">Novo</button>


<dialog id="modal">
    <!--  -->
    <div class="modal position-static d-block" tabindex="-1" role="dialog" id="modalSignin">
        <div>
            <div>
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2" id="txttitulo"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="fechar" onclick="fecharModal()"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form class="" id="form">
                        <div class="form-floating mb-3">
                            <input type="text" id="txtid" name="txtid" value="NOVO" style="background-color: rgba(128, 128, 128, 0.103); font: bolder;" readonly class="form-control rounded-3">
                            <label for="floatingInput">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="txtnome" name="txtnome" required class="form-control rounded-3">
                            <label for="floatingPassword">Nome</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" id="txtcpf" name="txtcpf" required class="form-control rounded-3">
                            <label for="floatingPassword">CPF</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input input type="number" id="txttel" name="txttel" required class="form-control rounded-3">
                            <label for="floatingPassword">Telefone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" id="txtcep" name="txtcep" required class="form-control rounded-3">
                            <label for="floatingPassword">CEP</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="txtuf" name="txtuf" required class="form-control rounded-3">
                            <label for="floatingPassword">UF</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="txtmunic" name="txtmunic" required class="form-control rounded-3">
                            <label for="floatingPassword">Munícipio</label>
                        </div>
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" id="concluir">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</dialog>
<!-- Importando jquery -->
<script src="assets\js\jquery.js"></script>
<script src="assets\js\cliente.js"></script>


</html>