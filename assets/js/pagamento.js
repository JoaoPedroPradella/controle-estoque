const tituloCadPagamentoCad = document.querySelector('h1#txttitulopagcad')
const modalPagamento = document.querySelector("dialog#modalPagamento")
const modalCadPagamento = document.querySelector("dialog#modalCadPagamento")

// Abrir modal NOVO

// Abrir modal da lista de pagamentos
function Pagamentos() {
    $('.form-control').val('');
    $('#txtid').val('NOVO');
    modalPagamento.showModal()
}

// Fechar modal da listagem
function fecharModalPag() {
    modalPagamento.close()
}

// Mostrar a listagem de clientes
function listarPag() {
    let tipo = 'Listagem de Pagamentos';

    $.ajax({
        url: 'src/Application/selecionar-pagamento.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            tipo = '';
            $('#listaPagamento').empty();
            for (var i = 0; i < result.length; i++) {
                $('#listaPagamento').prepend(
                    '<tr> <td>' + result[i].id + '</td><td>' + result[i].descricao + '</td><td class="opcoes"><a onclick="alterarCadPagamento(' + result[i].id + ', \'alterar\')" id="editar"><img src="assets/img/botao-editar.png" alt="Editar"></a></td><td class="opcoes"><a onclick="excluirPag(' + result[i].id + ')" id="excluir" value="teste"><img src="assets/img/excluir.png"></a></td></tr>');
            }
        } else {
            alert(result.erro);
        }

    });
}

// Abrir modal da tela de cadastro de pagamentos
function novoPagamento() {
    tituloCadPagamentoCad.innerHTML = 'NOVO';
    $('.form-control').val('');
    $('#txtid').val('NOVO');
    modalCadPagamento.showModal()
}

// Fechar modal da tela de cadastro dos pagamentos
function fecharModalCadPag() {
    modalCadPagamento.close()
}


// Função para cadastrar/alterar pagamento
$('#concluirPag').click(function (e) {
    e.preventDefault();

    let id = $('#txtid').val();
    let desc = $('#txtdesc').val();

    $.ajax({
        url: 'src/Application/inserir-pagamento.php',
        method: 'POST',
        data: {
            'txtid': id,
            'txtdesc': desc,
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            listarPag();
            $('#txtdesc').val('');
            modalCadPagamento.close();
        } else {
            alert('Existem erros no cadastro! Verifique')
            console.log(result.erro);
        }
    });
});

// Função para trazer os dados do cliente no modal
function alterarCadPagamento(id) {
    titulo.innerHTML = 'Editando';

    modalCadPagamento.showModal()

    $.ajax({
        url: 'src/Application/selecionar-pagamento.php',
        method: 'POST',
        data: {
            'id': id
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            $('#txtid').val(result['id']);
            $('#txtdesc').val(result['descricao']);
        } else {
            alert('Existem erros no cadastro! Verifique')
            console.log(result.erro); // Mostra o erro retornado pelo PHP
        }
    });
}

// Função para trazer excluir o cadastro
function excluirPag(id) {
    if (confirm('Tem certeza que deseja excluir?')) {
        $.ajax({
            url: 'src/Application/exc-pagamento.php',
            method: 'POST',
            data: {
                'id': id
            },
            dataType: 'json'
        }).done(function (result) {
            tipo = '';
            if (!result.erro) {
                alert(result);
                listarPag();
            } else {
                alert('Existem erros! Verifique')
                console.log(result.erro);
            }
        });
    }
}



listarPag();