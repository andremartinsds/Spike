<?php

namespace App;
use App\Pedido;

use Illuminate\Database\Eloquent\Model;

class FasePedido extends Model
{
    protected $fillable = ['fase', 'id_pedido'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
