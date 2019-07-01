@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('CSI 477 - Trabalho prático 02 e 03')])

@section('content')
<div class="container" style="height: auto;">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <h1 class="text-white text-center">{{ __('Procedimentos disponíveis') }}</h1>
      </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <p class="card-category">R$ 3,00</p>
                        <h3 class="card-title">Vacina</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons "></i>
                            <a href="#pablo">Quero contratar</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
