@extends('layouts.app', ["current"=>"categorias"])

@section('body')

    <div class="card">
        
        <div class="card-header">
            Lista de Categorias
        </div>
        <div class="card-body">
            <table class="table table-sm table-hover" id="tableCategorias" style="text-align: center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Opções</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <div class="card-footer text-muted">
                <button class="btn btn-primary btn-sm" role="button" onclick="novaCategoria()">Nova
                    categoria</button>
            </div>
        </div>

        <!-- ModalCategorias -->
        <div class="modal fade" id="modalCategorias" tabindex="-1" role="dialog" aria-labelledby="modalCategoriasTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categorias">Nova Categoria</h5>
                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>-->
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id" value>
                        <form id="formCategorias">
                            <div class="form-group">
                                <label for="nomeCategoria">Nome</label>
                                <input type="text" class="form-control" id="nomeCategoria" placeholder="nome">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">

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

            function novaCategoria(){
                //limpar campos do modal caso sai sem confirmar os dados preenchidos
                $('#id').val('')
                $('#nomeCategoria').val('')

                $('#modalCategorias').modal('show')
            }

            function montarLinha(c) {
                var linha = "<tr>" +
                    "<td>" + c.id + "</td>" +
                    "<td>" + c.name + "</td>" +
                    "<td>" +
                    '<button class="btn btn-sm btn-primary" onclick="editar(' + c.id + ')">Editar</button> ' +
                    ' <button class="btn btn-sm btn-danger" onclick="excluir(' + c.id + ')">Apagar</button>' +
                    "</td>" +
                    "</tr>";

                return linha;
            }

            function carregarCategorias() { //carregando todos os categorias via ApI
                $.getJSON('/api/categorias', function(categorias) {
                    for (i = 0; i < categorias.length; i++) {
                        linha = montarLinha(categorias[i]);
                        $("#tableCategorias>tbody").append(linha);
                    }
                });
            }


            function criarCategoria() { //cadastrando uma nova categoria
                cats = { //criando o objeto
                    nome: $('#nomeCategoria').val(),
                };

                //console.log(cats);

                $.post('api/categorias', cats, function(data) {
                    categoria = JSON.parse(data);
                    linha = montarLinha(categoria);
                    $("#tableCategorias>tbody").append(linha);
                })

            }

            function salvarCategoria() {
                cats = {
                    id: $('#id').val(),
                    nome: $('#nomeCategoria').val()
                };

                $.ajax({
                    type: "PUT",
                    url: "/api/categorias/" + cats.id,
                    context: this,
                    data: cats,
                    success: function(data) {
                        cats = JSON.parse(data);

                        linhas = $("#tableCategorias>tbody>tr");
                        e = linhas.filter(function(i, e) {
                            return (e.cells[0].textContent == cats.id)
                        });

                        if (e) {
                            e[0].cells[0].textContent = cats.id;
                            e[0].cells[1].textContent = cats.name;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            $('#formCategorias').submit(function(event) {
                event.preventDefault();

                if ($("#id").val() != '') {
                    salvarCategoria();

                } else {
                    criarCategoria();
                }
                $("#modalCategorias").modal('hide'); // fechar o modal do cadastro após clicar em salvar
            });

            $(function() {
                carregarCategorias();
                //carregarProdutos();
            });

            function editar(id){
                $.getJSON('api/categorias/' + id, function(data){
                    console.log(data);

                    $("#id").val(data.id);
                    $("#nomeCategoria").val(data.name);

                    $("#modalCategorias").modal('show');
                });
            }

            function excluir(id){
                $.ajax({
                    type: "DELETE",
                    url: "/api/categorias/" + id,
                    context: this,

                    success: function(){//removendo linhas da tabela sem dar request na pagina

                        console.log("Apagado com Sucesso!")

                        linha = $('#tableCategorias>tbody>tr')

                        e = linha.filter(function(i, elemento){
                            return elemento.cells[0].textContent == id;
                        });

                        if(e){
                            e.remove();
                        }
                    }, 

                    error:function(error){
                        console.log(error);
                    }
                });
            }

        </script>
    @endsection
