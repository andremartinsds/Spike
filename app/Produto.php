<?php

namespace App;
use App\Pagina;
use App\imagemProduto;
use App\Pedido;
use App\MolduraProduto;
use App\ProdutoDetalheMoldura;
use App\User;
use App\Mostrar;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = 
    [
        'nome',
        'descricao',
        'preco',
        'formato_embalagem',
        'peso',
        'comprimento',
        'altura',
        'largura',
        'diametro',
        'pagina_id',
        'user_id',
        'id_mostra',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pagina()
    {
        return $this->belongsTo(Pagina::class);
    }

    public function imagemProdutos()
    {
        return $this->hasMany(imagemProduto::class);
    }

    public function molduraProduto()
    {
        return $this->belongsToMany(MolduraProduto::class, 'produto_moldura', 'produto_id', 'moldura_id');
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class);
    }

    public function produtoDetalheMoldura()
    {
        return $this->hasOne(ProdutoDetalheMoldura::class,'id_produto','id');
    }

    public function mostrarTamanho()
    {
        return $this->hasOne(Mostrar::class);
    }
}
