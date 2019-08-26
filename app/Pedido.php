<?php

namespace App;
use App\Cliente;
use App\Produto;
use App\PedidoComprovante;
use App\FasePedido;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    
    protected $fillable = ['id_cliente','tipo_frete','tipo_pagamento','valor_frete','subtotal','numero_cep_ato_da_compra'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'id_cliente', 'id');
    }
    public function comprovante()
    {
        return $this->hasOne(PedidoComprovante::class);
    }

    public function fases()
    {
        return $this->hasMany(FasePedido::class, 'id_pedido','id');
    }
}
