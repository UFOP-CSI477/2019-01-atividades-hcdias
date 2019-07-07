@extends('layouts.app', ['activePage' => 'tests', 'titlePage' => __('Manage Tests')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Tests') }}</h4>
                <p class="card-category"> {{ __('Here you can manage tests') }}</p>
              </div>
              <div class="card-body">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="#" class="btn btn-sm btn-primary">{{ __('Add Test') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Pacient') }}
                      </th>
                      <th>
                          {{ __('Procedure') }}
                      </th>
                      <th>
                        {{ __('Price') }}
                      </th>
                      <th>
                        {{ __('Test date') }}
                      </th>
                      <th>
                        {{ __('Creation date') }}
                      </th>                      
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($procedures as $procedure)
                        @php
                          $procedure->tests->sortByDesc('date')
                        @endphp
                        @foreach($procedure->tests as $test)
                          <tr>
                            <td>
                              {{ $test->users->name }}
                            </td>
                            <td>
                              {{ $test->procedures->name }}
                            </td>
                            <td>
                              {{ $test->procedures->price }}
                            </td>
                            <td>
                              {{ date('d/m/Y H:i',strtotime($test->date)) }}
                            </td>
                            <td>
                              {{ date('d/m/Y H:i',strtotime($test->created_at)) }}
                            </td>
                            <td class="td-actions text-right">
                                <form action="{{ route('tests.destroy', $test) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    @if( $test->date > date("Y-m-d H:i:s"))
                                      <a rel="tooltip" class="btn btn-success btn-link" href="{{route('tests.edit', $test)}}" data-original-title="{{ __('Edit')}}" title="{{ __('Edit')}}">
                                        <i class="material-icons">edit</i>  
                                        <div class="ripple-container"></div>
                                      </a>
                                    @else
                                      <a rel="tooltip" class="btn btn-warning btn-link" href="#" data-original-title="{{__('You cannot edit past tests')}}" title="{{__('You cannot edit past tests')}}">
                                        <i class="material-icons">warning</i>  
                                        <div class="ripple-container"></div>
                                      </a>
                                    @endif
                                    <button type="button" class="btn btn-danger btn-link" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this test?") }}') ? this.parentElement.submit() : ''">
                                        <i class="material-icons">close</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                </form>
                            </td>
                          </tr>
                        @endforeach
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    @include('cart')
  </div>
@endsection