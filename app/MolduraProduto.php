<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produto;

class MolduraProduto extends Model
{
    protected $fillable = 
    [
        'tipo',
        'descricao',
        'user_id'
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_moldura', 'moldura_id', 'produto_id');
    }
}
