@extends('painel.layouts.app')
@inject('webbanners', 'App\WebBanner')
@section('menu')
@parent
@endsection

@section('content')
    
        <section class="aw-layout-content  js-content">
    
    
    <div class="page-header">
      <div class="container-fluid">
        <h1>
          Dashboard
        </h1>
      </div>
    </div>
    
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-sm-6">
        
          <div class="aw-box">
            <div class="aw-box__icon">
                <i class="fa fa-comment fa-3x" aria-hidden="true"></i>
            </div>
            <div class="aw-box__value">#</div>
            <div class="aw-box__title">Total de contatos</div>
          </div>
        
        </div>
    
        <div class="col-sm-6">
        
          <div class="aw-box">
            <div class="aw-box__icon">
              <i class="fa  fa-heartbeat  fa-3x"></i>
            </div>
            <div class="aw-box__value">#</div>
            <div class="aw-box__title">Total de vendas</div>
          </div>
        
        </div>
      </div>
    
      <div class="row">
        <div class="col-sm-6">
        
          <div class="aw-box">
            <div class="aw-box__icon">
                <i class="fa fa-camera fa-3x" aria-hidden="true"></i>
            </div>
            <div class="aw-box__value">#</div>
            <div class="aw-box__title">Total de Notícias</div>
          </div>
        
        </div>
        
        <div class="col-sm-6">
        
          <div class="aw-box">
            <div class="aw-box__icon">
                <i class="fa fa-picture-o fa-3x" aria-hidden="true"></i>
            </div>
          <div class="aw-box__value">{{$webbanners->all()->count()}}</div>
            <div class="aw-box__title">Páginas de Web Banner</div>
          </div>
        
        </div>
        
      </div>
    
        </section>
        
        
    
    </div>
    
    <div class="aw-search-modal  js-search-modal">
        <form action="#" class="aw-search-modal__form">
            <input class="aw-search-modal__input  js-search-modal-input" type="text" placeholder="O que você está procurando?"/>
            <div class="aw-search-modal__input-icon">
                <i class="glyphicon  glyphicon-search  js-search-modal-go"></i>
            </div>
        </form>
        
        <div class="aw-search-modal__controls">
            <i class="glyphicon glyphicon-remove  js-search-modal-close"></i>
        </div>
    </div>
    
@endsection
