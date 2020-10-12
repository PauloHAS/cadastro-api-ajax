@extends('layouts.app', ["current"=>"produtos"])

@section('body')

    <div class="card border">
        <div class="card-header">
            Lista de Produtos
        </div>
        <div class="card-body">
            <table class="table table-sm table-hover" id="tableProdutos" style="text-align: center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Estoque</th>
                        <th scope="col">Preço R$</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <div class="card-footer text-muted">
                <button class="btn btn-primary btn-sm" role="button" onclick="novoProduto()">Novo produto</button>
            </div>
        </div>

        <!-- ModalProdutos -->
        <div class="modal fade" id="modalProdutos" tabindex="-1" role="dialog" aria-labelledby="modalProdutosTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="produtos">Novo Produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="formProduto">
                            <input type="hidden" class="form-control" id="id" value>

                            <div class="form-group">
                                <label for="nomeProduto">Nome</label>
                                <input type="text" class="form-control" id="nomeProduto" placeholder="produto" required>
                            </div>

                            <div class="form-group">
                                <label for="estoqueProduto">Qtde Estoque</label>
                                <input type="number" class="form-control" id="estoqueProduto" placeholder="estoque"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="precoProduto">Preço R$</label>
                                <input type="text" class="form-control" id="precoProduto" placeholder="preço" required>
                            </div>

                            <div class="form-group">
                                <label for="categoriaProduto">Categoria</label>
                                <select class="form-control" id="categoriaProduto" required>
                                    <option value="" selected>Selecione a categoria</option>
                                    @foreach (App\Models\Categorias::all() as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                <button type="cancel" class="btn btn-secondary btn-sm"
                                    data-dismiss="modal">Cancelar</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    @endsection

    @section('javascript')
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            function novoProduto() {
                //limpar campos do modal caso sai sem cancelar ou confirmar
                $('#id').val('');
                $('#nomeProduto').val('')
                $('#estoqueProduto').val('')
                $('#precoProduto').val('')
                $('#categoriaProduto').val('')

                $('#modalProdutos').modal('show')
            }

            function montarLinha(p) {
                var linha = "<tr>" +
                    "<td>" + p.id + "</td>" +
                    "<td>" + p.name + "</td>" +
                    "<td>" + p.stock + "</td>" +
                    "<td>" + p.price + "</td>" +
                    "<td>" + p.categoria_id + "</td>" +
                    "<td>" +
                    '<button class="btn btn-sm btn-primary" onclick="editar(' + p.id + ')">Editar</button> ' +
                    ' <button class="btn btn-sm btn-danger" onclick="excluir(' + p.id + ')">Apagar</button>' +
                    "</td>" +
                    "</tr>";

                return linha;
            }

            function carregarProdutos() { //carregando todos os produtos via ApI
                $.getJSON('api/produtos', function(produtos) {
                    for (i = 0; i < produtos.length; i++) {
                        linha = montarLinha(produtos[i]);
                        $("#tableProdutos>tbody").append(linha);
                    }
                });
            }

            function criarProduto() { //função para criar um novo produto no banco de de dados
                prods = { // criação do objeto
                    nome: $('#nomeProduto').val(),
                    estoque: $('#estoqueProduto').val(),
                    preco: $('#precoProduto').val(),
                    categoria_id: $('#categoriaProduto').val()
                };

                $.post('api/produtos', prods, function(
                    data) { //função para salvar e atualizar os dados no navegador sem dar um refresh na pagina
                    produto = JSON.parse(data);
                    linha = montarLinha(produto);
                    $("#tableProdutos>tbody").append(linha);
                })
            }

            function salvarProduto() {
                prods = { // criação do objeto
                    id: $("#id").val(),
                    nome: $("#nomeProduto").val(),
                    estoque: $("#estoqueProduto").val(),
                    preco: $("#precoProduto").val(),
                    categoria_id: $("#categoriaProduto").val()
                };

                $.ajax({
                    type: "PUT",
                    url: "/api/produtos/" + prods.id,
                    context: this,
                    data: prods,

                    success: function(
                        data) { //atualizando as linhas da tabela view produto sem precisar atualizar a página
                        prods = JSON.parse(data);

                        linhas = $("#tableProdutos>tbody>tr")
                        e = linhas.filter(function(i, e) {
                            return (e.cells[0].textContent == prods.id);
                        });
                        if (e) {
                            e[0].cells[0].textContent = prods.id;
                            e[0].cells[1].textContent = prods.name;
                            e[0].cells[2].textContent = prods.stock;
                            e[0].cells[3].textContent = prods.price;
                            e[0].cells[4].textContent = prods.categoria_id;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            $('#formProduto').submit(function(event) {
                event.preventDefault();

                if ($("#id").val() != '') {
                    salvarProduto();

                } else {
                    criarProduto();
                }
                $("#modalProdutos").modal('hide'); // fechar o modal do cadastro após clicar em salvar
            });

            $(function() {
                //  carregarCategorias();
                carregarProdutos();
            });

            function editar(id) {
                $.getJSON('api/produtos/' + id, function(data) {
                    console.log(data);

                    $("#id").val(data.id);
                    $("#nomeProduto").val(data.name);
                    $("#estoqueProduto").val(data.stock);
                    $("#precoProduto").val(data.price);
                    $("#categoriaProduto").val(data.categoria_id);

                    $("#modalProdutos").modal('show');
                });
            }

            function excluir(id) {
                $.ajax({
                    type: "DELETE",
                    url: "/api/produtos/" + id,
                    context: this,

                    success: function() {
                        console.log("Apagado com sucesso");

                        linha = $('#tableProdutos>tbody>tr');

                        e = linha.filter(function(i, elemento) {
                            return elemento.cells[0].textContent == id;
                        });

                        if (e) {
                            e.remove();
                        }
                    },

                    error: function(error) {
                        console.log(error);
                    }
                });

            }

        </script>
    @endsection
