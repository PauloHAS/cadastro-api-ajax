<?php

namespace App\Http\Controllers;

use App\Models\Categorias as ModelsCategorias;
use Illuminate\Http\Request;

class Categorias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {

        return view('/categorias/categorias');

    }

    public function index()
    {
        $cats = ModelsCategorias::all();
        return json_encode($cats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cats = new ModelsCategorias();
        $cats->name = $request->input('nome');
        $cats->save();
        return json_encode($cats);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)//dados para a API
    {
        $cats = ModelsCategorias::find($id);
        if(isset($cats)){
            return json_encode($cats);
        }

        return response("Categoria não encontrada!", 404);
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
    public function update(Request $request, $id)//dados para a API
    {
        $cats = ModelsCategorias::find($id);
        if(isset($cats)){
            $cats->name = $request->input('nome');
            $cats->save();
            return json_encode($cats);
        }
        return response('produto não encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //dados para a API
    {
        $cats = ModelsCategorias::find($id);
        if(isset($cats)){
            $cats->delete();
            return response('Apagado com sucesso', 200);
        }
        return response('produto não encontrado', 404);
    }
}
