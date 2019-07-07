@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
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
                                <a href="#" data-target="#test-request" data-toggle="modal" class = "test-request" data-procedure-id ="{{ $procedure->id }}" data-procedure-name ="{{ $procedure->name }}" data-procedure-price ="{{ $procedure->price }}">{{ __('Schedule test')}}</a>
                          </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="test-request" tabindex="-1" role="dialog" aria-labelledby="testRequestLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="testRequestLabel">{{ __('Schedule test') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ __('Select a date for your test')}}</p>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                  <div class="form-group" id="date-container">
                    <label class="control-label">{{ __('Date') }}</label>
                    <input class="form-control datetimepicker" name="date" id="procedure-date" type="text" value="" required="true" aria-required="true"/>
                    <span class="material-icons form-control-feedback">clear</span>
                    <input type="hidden" id="procedure-id" />
                    <input type="hidden" id="procedure-price" />
                    <input type="hidden" id="procedure-name" /> 
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-primary" id="schedule-test">{{ __('Schedule test') }}</button>
          </div>
        </div>
      </div>
    </div>  
    @include('cart') 
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      //inicia o datetimepicker
      $('.datetimepicker').datetimepicker({
          icons: {
              time: "fa fa-clock-o",
              date: "fa fa-calendar",
              up: "fa fa-chevron-up",
              down: "fa fa-chevron-down",
              previous: 'fa fa-chevron-left',
              next: 'fa fa-chevron-right',
              today: 'fa fa-screenshot',
              clear: 'fa fa-trash',
              close: 'fa fa-remove'
          }
      }); 

    });
  </script>
@endpush