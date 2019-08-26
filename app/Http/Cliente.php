<?php

namespace App;
use App\Pedido;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'name', 'email', 'endereco','rg','cpf','phone','phone_dois','obs',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

  
}
