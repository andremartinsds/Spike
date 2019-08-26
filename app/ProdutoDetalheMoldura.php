<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produto;

class ProdutoDetalheMoldura extends Model
{
    protected $table = 'produto_detalhe_moldura';
    protected $fillable = 
    [
        'id_produto',
        'moldura',
    ];

    public function produto()
    {
        return $this->belongsTo(Protudo::class);
    }

}
