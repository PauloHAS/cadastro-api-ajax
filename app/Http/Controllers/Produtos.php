<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produtos as ModelsProdutos;


class Produtos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
       //$prods = ModelsProdutos::with('categorias')->get();

        return view('/produtos/produtos');
    }

    public function index()
    {
        //retornando dados para a API
        //$prods = ModelsProdutos::join('categorias','categoria_id','=', 'id')->select('produtos.*', 'categoria.name as nome_categoria');
        
        $prods = ModelsProdutos::with('categorias')->get();

       //$prods = ModelsProdutos::all();
          return ($prods->toJson());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prods = new ModelsProdutos();
        $prods->name = $request->input('nome');
        $prods->stock = $request->input('estoque');
        $prods->price = $request->input('preco');
        $prods->categoria_id = $request->input('categoria_id');

        $prods->save();
        return json_encode($prods);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prods = ModelsProdutos::find($id);

        if(isset($prods)){
            return json_encode($prods);
        }
        return response("Produto não encontrado", 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prods = ModelsProdutos::find($id);
        if(isset($prods)){
            $prods->name = $request->input("nome");
            $prods->stock = $request->input("estoque");
            $prods->price = $request->input("preco");
            $prods->categoria_id = $request->input("categoria_id");

            $prods->save();

            return json_encode($prods);
        }
        return response("Produto Não encontrado", 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prods = ModelsProdutos::find($id);
        if(isset($prods)){
            $prods->delete();
            return response("Excluido com sucesso", 200);
        }
        return response("Produto Não Encontrado", 404);
    }
}
