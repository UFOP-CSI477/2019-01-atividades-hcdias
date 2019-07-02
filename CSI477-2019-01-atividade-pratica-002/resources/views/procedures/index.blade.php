@extends('layouts.app', ['activePage' => 'procedures', 'titlePage' => __('Manage Procedures')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Procedures') }}</h4>
                <p class="card-category"> {{ __('Here you can manage procedures') }}</p>
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
                    <a href="{{ route('procedures.create') }}" class="btn btn-sm btn-primary">{{ __('Add procedure') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Price') }}
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
                        <tr>
                          <td>
                            {{$procedure->name}}
                          </td>
                          <td>
                            {{$procedure->price}}
                          </td>
                          <td>
                            {{$procedure->created_at->format('d/m/Y')}}
                          </td>
                          <td class="td-actions text-right">
                              <form action="{{route('procedures.destroy',$procedure)}}" method="post">
                                  @csrf
                                  @method('delete')
                              
                                  <a rel="tooltip" class="btn btn-success btn-link" href="{{route('procedures.edit',$procedure)}}" data-original-title="" title='{{__("Edit procedure")}}'>
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                  </a>
                                  <button type="button" class="btn btn-danger btn-link" data-original-title="" title='{{__("Delete procedure")}}' onclick="confirm('{{ __("Are you sure you want to delete this procedure?") }}') ? this.parentElement.submit() : ''">
                                      <i class="material-icons">close</i>
                                      <div class="ripple-container"></div>
                                  </button>
                              </form>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection