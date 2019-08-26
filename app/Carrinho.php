<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produto;
use Session;

class Carrinho extends Model
{
    private $items = [];
    
    public function __construct()
    {
        if( Session::has('carrinho') ) {
            $carrinho = Session::get('carrinho');
            $this->items = $carrinho->items;
        }
    }
    
    public function add(Produto $produto)
    {
        if( isset($this->items[$produto->id]) )
            $this->items[$produto->id] = [
                'item' => $produto,
                'qtd' => $this->items[$produto->id]['qtd'] + 1,
            ];
        else
            $this->items[$produto->id] = [
                'item' => $produto,
                'qtd' => 1,
            ];
    }
    
    public function remove(Produto $produto)
    {
        if( isset($this->items[$produto->id]) && $this->items[$produto->id]['qtd'] > 1 )
            $this->items[$produto->id] = [
                'item' => $produto,
                'qtd' => $this->items[$produto->id]['qtd'] - 1,
            ];
        elseif( isset($this->items[$produto->id]) )
            unset($this->items[$produto->id]);
    }
    
    public function getItems()
    {
        return $this->items;
    }
    //deverá trazer um array de ids
    public function getItemsId()
    {
        foreach($this->items as $item) {
            $id = $item['item']->id;
        }
        
        return $id;
    }
    
    public function total()
    {
        $total = 0;
        
        foreach($this->items as $item) {
            $subTotal = $item['item']->preco * $item['qtd'];
            
            $total += $subTotal;
        }
        
        return $total;
    }

    public function totalComFrete()
    {
        $total = 0;
        
        foreach($this->items as $item) {
            $subTotal = $item['item']->preco * $item['qtd'];
            
            $total += $subTotal;
            $totalComFrete = $frete[$item]["valor"] + $total;
        }
        $frete = Session::get('frete');
        return $totalComFrete;
    }

    public function pesoTotal()
    {
        $total = 0;
        
        foreach($this->items as $item) {
            $pesoTotal = $item['item']->peso * $item['qtd'];
            
            $total += $pesoTotal;
        }
        
        if($total > 40) {
			$total = 40;
		}
        
        return $total;
    }

    public function comprimentoTotal()
    {
        $total = 0;
        
        foreach($this->items as $item) {
            $comprimentoTotal = $item['item']->comprimento;
            if($comprimentoTotal >= $total){
                $total = $item['item']->comprimento;
            } 
        }
        return $total;
    }

    public function alturaTotal()
    {
        $total = 0;
        
        foreach($this->items as $item) {
            $alturaTotal = $item['item']->altura * $item['qtd'];
            $total += $alturaTotal;

        }
        return $total;
    }

    public function larguraTotal()
    {
        $total = 0;
        
        foreach($this->items as $item) {
            $larguraTotal = $item['item']->largura;
            
            if($larguraTotal >= $total){
                $total = $item['item']->largura;
            } 
        }
        return $total;
    }

    public function diametroTotal()
    {
        $total = 0;
        
        foreach($this->items as $item) {
            $diametroTotal = $item['item']->diametro * $item['qtd'];
            
            $total += $diametroTotal;
        }

        if($total > 90) {
			$total = 90;
		}
        
        return $total;
    }
    
    
    public function totalItems()
    {
        return count($this->items);
    }
    
    
    public function emptyCart()
    {
        if( Session::has('carrinho') )
            Session::forget('carrinho');
    }
}

