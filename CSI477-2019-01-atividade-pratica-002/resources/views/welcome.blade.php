@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('CSI 477 - Trabalho prático 02 e 03')])

@section('content')
    <div class="container" style="height: auto;">
        <div class="row justify-content-center">
          <div class="col-lg-7 col-md-8">
              <h1 class="text-white text-center">{{ __('Available Procedures') }}</h1>
          </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                @foreach($procedures as $procedure)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">store</i>
                                </div>
                                <p class="card-category">R$ {{$procedure->price }}</p>
                                <h3 class="card-title">{{ $procedure->name }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons "></i>
                                    <a href="#" data-target="#loginRequest" data-toggle="modal" >{{ __('Schedule test')}}</a>
                              </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="loginRequest" tabindex="-1" role="dialog" aria-labelledby="loginRequestLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loginRequestLabel">{{ __('Oops') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{ __('You must login in order to schedule a test.')}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
          </div>
        </div>
      </div>
    </div>
@endsection
