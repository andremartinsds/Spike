<?php

namespace App;
use App\Pedido;

use Illuminate\Database\Eloquent\Model;

class PedidoComprovante extends Model
{
    public $timestamps = false;
    protected $table = 'pedido_comprovante';
    protected $fillable = ['comprovante', 'produto_id'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
