@extends('layouts.app', ['activePage' => 'tests', 'titlePage' => __('Manage Tests')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('tests.update',$test) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit Test') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('tests.index') }}" class="btn btn-sm btn-primary">{{ __('Back') }}</a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label class="col-sm-6 col-form-label">{{ __('Test date') }}</label>
                    <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }} datetimepicker" name="date" type="text" placeholder="{{ __('Date') }}" value="{{ date('d/m/Y H:i',strtotime($test->date)) }}" required />
                      @if ($errors->has('date'))
                        <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
                      @endif
                    </div>
                  </div>
                </div>  
                <div class="row">
                  <div class="col-sm-6">
                    <label class="col-sm-6 col-form-label">{{ __('Procedure name') }}</label>
                    <div class="form-group">
                      <input class="form-control" type="text" value="{{ $test->procedures->name }}" disabled="true" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="col-sm-6 col-form-label">{{ __('Procedure price') }}</label>
                    <div class="form-group">
                      <input class="form-control" type="text" value="{{ $test->procedures->price }}" disabled="true" />
                    </div>
                  </div>
                </div>          
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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