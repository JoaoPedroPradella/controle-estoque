const titulo = document.querySelector('h1#txttitulo')


// Abrir modal NOVO
function novoItem() {
    titulo.innerHTML = 'NOVO';
    $('#concluir').show();
    $('#form input.form-control').val('');
    $('#txtid').val('NOVO');
    modal.showModal()
}

// Fechar modal
function fecharModal() {
    modal.close()
}

// Função para cadastrar/alterar cliente
$('#form').submit(function (e) {
    e.preventDefault();

    if ($('#txtqtd').val() < 1) {
        alert('A quantidade não pode ser menor ou igual a zero!');
        exit(0);
    }

    let id = $('#txtid').val();
    let desc = $('#txtdesc').val();
    let preco = $('#txtpreco').val();
    let qtd = $('#txtqtd').val();
    $.ajax({
        url: 'src/Application/inserir-item.php',
        method: 'POST',
        data: {
            'txtid': id,
            'txtdesc': desc,
            'txtpreco': preco,
            'txtqtd': qtd
        },
        dataType: 'json'
    }).done(function (result) {
        modal.close();
        if (!result.erro) {
            alert(result);
            listarItens();
        } else {
            alert('Existem erros no cadastro! Verifique')
            console.log(result.erro);
        }
    });
}); 


// Mostrar a listagem de clientes
function listarItens() {
    let tipo = 'listagem';

    $.ajax({
        url: 'src/Application/selecionar-item.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            tipo = '';
            $('#lista').empty();

            for (var i = 0; i < result.length; i++) {
                $('#lista').prepend(
                    '<tr> <td>' + result[i].id + '</td><td>' + result[i].descricao + '</td><td class="opcoes"><a onclick="alterarCadastro(' + result[i].id + ', \'alterar\')" id="editar"><img src="assets/img/botao-editar.png"</a></td><td class="opcoes"><a onclick="alterarCadastro(' + result[i].id + ', \'detalhes\')" id="detalhes"><img src="assets/img/pesquisa.png"</a></td><td class="opcoes"><a onclick="excluir(' + result[i].id + ')" id="excluir" value="teste"><img src="assets/img/excluir.png"</a></td></tr>');
            }
        } else {
            console.log(result.erro);
        }

    });
}

// Função para trazer os dados do cliente no modal
function alterarCadastro(id, acao) {
    if (acao == 'detalhes') {
        titulo.innerHTML = 'Detalhes';
        $('#concluir').hide();
    } else {
        titulo.innerHTML = 'Editando';
        $('#concluir').show();
    }

    modal.showModal()

    $.ajax({
        url: 'src/Application/selecionar-item.php',
        method: 'POST',
        data: {
            'id': id
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            $('#txtid').val(result['id']);
            $('#txtdesc').val(result['descricao']);
            $('#txtpreco').val(result['preco']);
            $('#txtqtd').val(result['quantidade']);
        } else {
            alert('Existem erros! Verifique')
            console.log(result.erro);// Mostra o erro retornado pelo PHP
        }
    });
}

// Função para trazer excluir o cadastro
function excluir(id) {
    if (confirm('Tem certeza que deseja excluir?')) {
        $.ajax({
            url: 'src/Application/exc-item.php',
            method: 'POST',
            data: {
                'id': id
            },
            dataType: 'json'
        }).done(function (result) {
            tipo = '';
            if (!result.erro) {
                alert(result);
                listarItens();
            } else {
                alert('Existem erros! Verifique')
                console.log(result.erro);
            }
        });
    }
}

function voltarPag() {
    window.location = 'sistema.php';
}

// Carrega a listagem de clientes pela primeira vez
listarItens();