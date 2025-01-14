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
    <title>Vendas</title>
</head>

<main>
    <div class="cabecalho">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <h1 class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                </svg>
                <span class="fs-4">Lista de Vendas</span>
            </h1>

            <ul class="nav nav-pills">
                <li class="nav-item"><button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="voltarPag()">Menu</button></li>
            </ul>
        </header>
    </div>
</main>

<!-- Lista de vendas -->
<table>
    <thead>
        <tr>
            <th id="numero">Número</th>
            <th id="cliente">Cliente</th>
            <th id="valor">Valor Total</th>
            <th id="pag">Pagamento</th>
            <th id="data">Data</th>
        </tr>
    </thead>
    <tbody id="lista">
        <!-- Linhas serão adicionadas dinamicamente aqui -->
    </tbody>
</table>

<button class="mb-2 btn btn-lg rounded-3 btn-primary" onclick="novaVenda()" id="Novo">Nova Venda</button>
<button class="mb-2 btn btn-lg rounded-3 btn-primary" onclick="Pagamentos()" id="pag">Pagamentos</button>

<!-- Modal da vendas -->
<dialog id="modalVenda">
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
                            <input type="text" id="txtnum" name="txtnum" style="background-color: rgba(128, 128, 128, 0.103); font: bolder;" readonly class="form-control rounded-3">
                            <label for="floatingPassword">Número</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="clientes" id="clientes" class="form-control rounded-3"> </select>
                            <label for="floatingPassword">Cliente</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select input type="text" name="pagamento" id="pagamento" required class="form-control rounded-3"> </select>
                            <label for="floatingPassword">Pagamento</label>
                        </div>
                        <div id="infVenda">
                            <div id="infItem">
                                <div class="form-floating mb-3">
                                    <select type="text" name="produtos" id="produtos" required class="form-control rounded-3"> </select>
                                    <label for="floatingPassword">Produtos</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" step="0.01" min="0" id="txtqtd" name="txtqtd" required class="form-control rounded-3">
                                    <label for="floatingPassword">Qtd</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" step="0.01" min="0" name="txtprec" id="txtprec" required class="form-control rounded-3">
                                    <label for="floatingPassword">Preço</label>
                                </div>
                            </div>
                            <button id="incluir" type="button" onclick="listarItens()" class=" mb-2 btn btn-lg rounded-3 btn-primary">Incluir</button>
                            Total: <label for="total" id="total"></label>
                        </div>

                        <!-- Lista de itens na venda -->
                        <div id="itensLista">
                            <table id="tabelaItens">
                                <thead id="cabItens">
                                    <tr>
                                        <th id="desc">Descrição</th>
                                        <th id="qtd">Quantidade</th>
                                        <th id="pUnit">Preço Unt</th>
                                    </tr>
                                </thead>
                                <tbody id="listaItens">
                                    <!-- Linhas serão adicionadas dinamicamente aqui -->
                                </tbody>
                            </table>
                        </div>

                        <div class="form-floating mb-3" id="divTotal">
                            <input input type="text" name="vtotal" id="vtotal" required class="form-control rounded-3" readonly> </input>
                            <label for="floatingPassword">Valor Total</label>
                        </div>

                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" id="concluir">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</dialog>

<!-- Modal listagem de pagamentos -->
<dialog id="modalPagamento">
    <main>
        <div class="cabecalho">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <h1 class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                    <svg class="bi me-2" width="40" height="32">
                    </svg>
                    <span class="fs-4">Lista de Pagamentos</span>
                </h1>

                <ul class="nav nav-pills">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="fechar" onclick="fecharModalPag()"></button>
                </ul>
            </header>
        </div>
    </main>

    <form id="form">
        <table>
            <thead>
                <tr>
                    <th id="codigo">Código</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody id="listaPagamento">
                <!-- Linhas serão adicionadas dinamicamente aqui -->
            </tbody>
        </table>
    </form>
    <button class="mb-2 btn btn-lg rounded-3 btn-primary" onclick="novoPagamento()" id="Novo">Novo</button>
</dialog>

<!-- Modal cadastro de pagamentos -->
<dialog id="modalCadPagamento">
    <div class="modal position-static d-block" tabindex="-1" role="dialog" id="modalSignin">
        <div>
            <div>
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2" id="txttitulopagcad"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="fechar" onclick="fecharModalCadPag()"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form class="" id="form">
                        <div class="form-floating mb-3">
                            <input type="text" id="txtid" name="txtid" value="NOVO" style="background-color: rgba(128, 128, 128, 0.103); font: bolder;" required readonly class="form-control rounded-3">
                            <label for="floatingInput">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="txtdesc" name="txtdesc" required class="form-control rounded-3">
                            <label for="floatingPassword">Descricao</label>
                        </div>
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" id="concluirPag" type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</dialog>
<script src="assets\js\jquery.js"></script>
<script src="assets\js\venda.js"></script>
<script src="assets\js\pagamento.js"></script>

</html>