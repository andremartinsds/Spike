<?php

namespace App;

use App\Pedido;
use App\Cidade;
use App\Estado;
use Illuminate\Database\Eloquent\Model;
use Session;

class Cliente extends Model
{
    protected $fillable =
        [
        'nome',
        'email',
        'cpf',
        'telefone',
        'endereco',
        'senha',
        'cep',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'id_estado',
    ];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class);
    }
    public function cidade()
    {
        return $this->belongsToMany(Cidade::class);
    }

    public function estados()
    {
        return $this->belongsTo(Estado::class,'id_estado');
    }

   
}
