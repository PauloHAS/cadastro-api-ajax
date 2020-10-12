@extends('layouts.app', ["current"=>"home"])

@section('body')

    <div class="card text-center">
        <div class="card-header">
            Gerenciamento de Produtos
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Produtos</h5>
                            <p class="card-text">Experimente essa fantastica experiencia que é usar a api ajax para
                                desenvolver suas aplicações.</p>
                            <a href="/produtos" class="btn btn-primary btn-sm">Produto</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Categorias</h5>
                            <p class="card-text">Experimente essa fantastica experiencia que é usar a api ajax para
                                desenvolver suas aplicações.</p>
                            <a href="/categorias" class="btn btn-primary btn-sm">Categoria</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            2019 - {{ date('Y') }}
        </div>
    </div>
@endsection
