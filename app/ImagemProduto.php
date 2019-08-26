<?php

namespace App;
use App\Produto;

use Illuminate\Database\Eloquent\Model;

class ImagemProduto extends Model
{
    protected $table = 'imagem_produtos';
    protected $fillable = ['nome', 'produto_id'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
