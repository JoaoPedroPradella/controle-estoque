const titulo = document.querySelector('h1#txttitulo');
const modal = document.querySelector('dialog#modalVenda');
let total = document.querySelector('label#total');
let itemId = 1;

// Preencher os camnpos ao recarregar a página
$(document).ready(function () {
    let tipo = 'listagem';

    // Listar clientes no select
    $.ajax({
        url: 'src/Application/selecionar-cliente.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            $('#clientes').empty();

            for (var i = 0; i < result.length; i++) {
                $('#clientes').prepend(
                    '<option value=' + result[i].id + '>' + result[i].nome + '</option>');
            }

        } else {
            alert(result.erro); // Mostra o erro retornado pelo PHP
        }
    });

    // Listar pagamentos no select 
    $.ajax({
        url: 'src/Application/selecionar-pagamento.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            $('#pagamento').empty();

            for (var i = 0; i < result.length; i++) {
                $('#pagamento').prepend(
                    '<option value=' + result[i].id + '>' + result[i].descricao + '</option>');
            }
        } else {
            alert(result.erro); // Mostra o erro retornado pelo PHP
        }
    });
});

// Abrir modal NOVO
function novaVenda() {
    titulo.innerHTML = 'NOVO';
    $('#form input.form-control').val('');
    $('#txtnum').val('NOVO');
    document.querySelector('select#clientes').disabled = false;
    document.querySelector('select#pagamento').disabled = false;
    total.innerHTML = '0';
    $('#divTotal').hide();
    $('#infVenda').show();
    $('#concluir').show();
    $('#txtqtd').val('1');
    $('#listaItens').empty();

    let tipo = 'listagem';


    // Listar produtos no select 
    $.ajax({
        url: 'src/Application/selecionar-item.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            $('#produtos').empty();
            //append('<option value="">Selecione um produto</option>')

            for (var i = 0; i < result.length; i++) {
                $('#produtos').prepend(
                    '<option value=' + result[i].id + '>' + result[i].descricao + '</option>');
            }
            $('#produtos').val('');
        } else {
            console.log(result.erro); // Mostra o erro retornado pelo PHP
        }
    });


    // Selecionar preço de um item 
    let idItem = document.getElementById('produtos');

    idItem.addEventListener('change', function () {
        // Obtém o valor selecionado
        const selectedValue = this.value;

        // Seleciona o preço do item
        tipo = '';
        $.ajax({
            url: 'src/Application/selecionar-item.php',
            method: 'POST',
            data: {
                'listagem': tipo,
                'id': selectedValue
            },
            dataType: 'json',
        }).done(function (result) {
            if (!result.erro) {
                tipo = 'listagem';
                $('#txtprec').val(result.preco);
            } else {
                console.log(result.erro); // Mostra o erro retornado pelo PHP
            }
        });
    });
    modal.showModal();

}

// Listar itens incluidos na venda 
function listarItens() {
    let desc = $('#produtos option:selected').text();
    let itemValue = $('#produtos option:selected').val();
    let qtd = $('#txtqtd').val();
    let prec = $('#txtprec').val();

    if (desc == '') {
        alert('Informe um item!');
        return;
    }
    if (qtd < 1) {
        alert('A quantidade não pode ser menor ou igual a zero!');
        return;
    }
    if (prec < 1) {
        alert('O preço não pode ser menor ou igual a zero!');
        return;
    }

    $('#listaItens').prepend(
        '<tr id="item-' + itemId + '" name="registro"> <td id="desc" data-value=' + itemValue + '>' + desc + '</td><td id="qtd">' + qtd + '</td><td id="prec">' + prec + '</td><td> <a href="#" onclick="excluirItem(' + itemId + ')" >Excluir</a> </td><tr>');
    $('#txtqtd').val('1');
    total.innerHTML = Number(total.innerHTML) + Number(prec);

    itemId++
}

// Excluir item da listagem de vendas
function excluirItem(id) {
    $('#item-' + id).remove();

    // Recalculando o valor total com base nos itens da lista
    let lista = document.getElementsByName('registro');
    let Novototal = 0;

    for (i = 0; i < lista.length; i++) {
        let linha = lista[i];

        // Seleciona os <td> específicos da linha atual
        let prec = linha.querySelector('#prec').textContent;
        Novototal += Number(prec);
    }

    total.innerHTML = Novototal;
}

// Fechar modal
function fecharModal() {
    modal.close();
}

// Função para cadastrar venda
$('#form').submit(function (e) {
    e.preventDefault();
    let lista = document.getElementsByName('registro');
    let clienteID = $('#clientes option:selected').val();
    let pagID = $('#pagamento option:selected').val();
    let cliente = $('#clientes option:selected').text();
    let pag = $('#pagamento option:selected').text();
    let valorTotal = total.textContent;
    let itens = [];


    for (i = 0; i < lista.length; i++) {
        let linha = lista[i];

        // Seleciona os <td> específicos da linha atual
        let desc = linha.querySelector('#desc').textContent;
        let idItem = linha.querySelector('#desc').getAttribute('data-value');
        let qtd = linha.querySelector('#qtd').textContent;
        let prec = linha.querySelector('#prec').textContent;

        // Adiciona o item ao array "itens"
        itens.push({
            desc: desc,
            idItem: idItem,
            qtd: qtd,
            prec: prec
        });
    }

    // Verificando se a venda tem itens
    if (itens.length === 0) {
        alert('Não é possível cadastrar uma venda sem itens!');
        return;
    }

    // Verificando o total pago e troco
    if (pag == 'Dinheiro') {
        let valor = prompt('Informe o valor pago');

        if (Number(valor) < Number(valorTotal)) {
            alert('O valor pago não pode ser menor que o valor total!');
            exit(0);
        } else if (Number(valor) > Number(valorTotal)) {
            let troco;

            troco = Number(valor) - Number(valorTotal);

            alert(`O troco é R$${Number(troco).toFixed(2).replace('.', ',')}`);
        }
    }
    // Convertendo objeto para JSON
    let objItens = JSON.stringify(itens);

    $.ajax({
        url: 'src/Application/inserir-venda.php',
        method: 'POST',
        data: {
            'txtcliente': cliente,
            'objItens': objItens,
            'txtpag': pag,
            'txtclienteID': clienteID,
            'txtpagID': pagID,
            'txttotal': valorTotal
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            console.log(result);
            modal.close();
            alert(result);
            listarVendas();
        } else {
            alert('Existem erros no cadastro! Verifique')
            console.log(result.erro);
        }
    });
});


// Mostrar a listagem de Vendas
function listarVendas() {
    let tipo = 'listagem';
    $.ajax({
        url: 'src/Application/selecionar-venda.php',
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
                    '<tr> <td>' + result[i].numero + '</td><td>' + result[i].cliente + '</td><td>' + result[i].valortotal + '</td><td>' + result[i].pagameto + '</td><td>' + result[i].data + '</td><td class="opcoes"><a onclick="detalhesVenda(' + result[i].numero + ')" id="detalhes"><img src="assets/img/pesquisa.png"></a></td><td class="opcoes"><a onclick="excluir(' + result[i].numero + ')" id="excluir" value="teste"><img src="assets/img/excluir.png"></a></td></tr>');
            }
        } else {
            console.log(result.erro);

        }
    });
}

// Função para trazer os dados do cliente no modal
function detalhesVenda(id) {
    titulo.innerHTML = 'Detalhes';
    $('#listaItens').empty();
    $('#infVenda').hide();
    $('#concluir').hide();
    document.querySelector('select#clientes').disabled = true;
    document.querySelector('select#pagamento').disabled = true;
    $('#divTotal').show();

    modal.showModal()

    $.ajax({
        url: 'src/Application/selecionar-venda.php',
        method: 'POST',
        data: {
            'id': id
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            const produtos = result[0]; // Array de produtos
            produtos.forEach(produto => {
                $('#listaItens').prepend(
                    '<tr> <td>' + produto.descricao + '</td><td>' + produto.quantidade + '</td><td>' + produto.precounit + '</td></tr>');
                $('#txtqtd').val('1');
            });
            const venda = result[1]; // Objeto com informações gerais
            $('#txtnum').val(venda.numvenda);
            $('#clientes option:selected').val(venda.cliente);
            $('#pagamento option:selected').text(venda.pagamento);
            $('#vtotal').val(venda.valortotal);
        } else {
            console.log(result.erro); // Mostra o erro retornado pelo PHP
        }
    });
}

// Função para trazer excluir o cadastro
function excluir(id) {
    if (confirm('Tem certeza que deseja excluir?')) {
        $.ajax({
            url: 'src/Application/exc-venda.php',
            method: 'POST',
            data: {
                'id': id
            },
            dataType: 'json'
        }).done(function (result) {
            tipo = '';
            if (!result.erro) {
                alert(result);
                listarVendas();
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
listarVendas();