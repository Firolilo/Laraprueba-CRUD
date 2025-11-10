@extends('adminlte::page')

@section('template_title')
    Biomasas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Biomasas') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('biomasas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Área (m²)</th>
                                        <th>Ubicación</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biomasas as $biomasa)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $biomasa->nombre }}</td>
                                            <td>{{ $biomasa->tipo }}</td>
                                            <td>{{ $biomasa->area_m2 }}</td>
                                            <td>{{ $biomasa->ubicacion }}</td>

                                            <td>
                                                <form action="{{ route('biomasas.destroy', $biomasa->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('biomasas.show', $biomasa->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('biomasas.edit', $biomasa->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $biomasas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
