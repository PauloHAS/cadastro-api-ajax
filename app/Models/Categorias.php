<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorias extends Model
{
    use HasFactory;

    public function produtos(){
        return $this->HasMany('App\Models\Produtos');
    }
}
