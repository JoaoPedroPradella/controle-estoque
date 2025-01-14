const titulo = document.querySelector('h1#txttitulo')
const modal = document.querySelector("dialog#modal")

// Abrir modal NOVO
function novoCliente() {
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
    let id = $('#txtid').val();
    let nome = $('#txtnome').val();
    let cpf = $('#txtcpf').val();
    let tel = $('#txttel').val();
    let uf = $('#txtuf').val();
    let munic = $('#txtmunic').val();
    let cep = $('#txtcep').val();
    $.ajax({
        url: 'src/Application/inserir-cliente.php',
        method: 'POST',
        data: {
            'txtid': id,
            'txtnome': nome,
            'txtcpf': cpf,
            'txttel': tel,
            'txtuf': uf,
            'txtmunic': munic,
            'txtcep': cep
        },
        dataType: 'json'
    }).done(function (result) {
        modal.close();
        if (!result.erro) {
            alert(result);
            listarClientes();
        } else {
            alert('Existem erros no cadastro! Verifique')
            console.log(result.erro);
        }
    });
});


// Mostrar a listagem de clientes
function listarClientes() {
    let tipo = 'listagem';

    $.ajax({
        url: 'src/Application/selecionar-cliente.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#lista').empty();

            for (var i = 0; i < result.length; i++) {
                $('#lista').prepend(
                    '<tr><td>' + result[i].id + '</td><td>' + result[i].nome + '</td><td class="opcoes"><a onclick="alterarCadastro(' + result[i].id + ', \'alterar\')" id="editar"><img src="assets/img/botao-editar.png" alt="Editar"></a></td><td class="opcoes"><a onclick="alterarCadastro(' + result[i].id + ', \'detalhes\')" id="detalhes"><img src="assets/img/pesquisa.png" alt="Detalhes"></a></td><td class="opcoes"><a onclick="excluir(' + result[i].id + ')" id="excluir" value="teste"><img src="assets/img/excluir.png"></a></td></tr>');
            }
        } else {
            alert(result.erro);
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
        url: 'src/Application/selecionar-cliente.php',
        method: 'POST',
        data: {
            'id': id
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            $('#txtid').val(result['id']);
            $('#txtnome').val(result['nome']);
            $('#txtcpf').val(result['cpf']);
            $('#txttel').val(result['telefone']);
            $('#txtuf').val(result['uf']);
            $('#txtmunic').val(result['municipio']);
            $('#txtcep').val(result['cep']);
        } else {
            alert('Existem erros! Verifique')
            console.log(result.erro); // Mostra o erro retornado pelo PHP
        }
    });
}

// Função para trazer excluir o cadastro
function excluir(id) {
    if (confirm('Tem certeza que deseja excluir?')) {
        $.ajax({
            url: 'src/Application/exc-cliente.php',
            method: 'POST',
            data: {
                'id': id
            },
            dataType: 'json'
        }).done(function (result) {
            tipo = '';
            if (!result.erro) {
                alert(result);
                listarClientes();
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
listarClientes();