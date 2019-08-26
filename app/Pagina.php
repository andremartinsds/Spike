<?php

namespace App;
use App\Categoria;
use App\Produto;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    protected $fillable = ['nome', 'user_id', 'categoria_id'];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
