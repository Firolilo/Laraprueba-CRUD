@extends('adminlte::page')

@section('template_title')
    Voluntarios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Voluntarios') }}
                            </span>
                             <div class="float-right">
                                <a href="{{ route('voluntarios.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nuevo') }}
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
                                        <th>Email</th>
                                        <th>Ciudad</th>
                                        <th>Zona</th>
                                        <th>Dirección</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($voluntarios as $voluntario)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $voluntario->user->name }}</td>
                                            <td>{{ $voluntario->user->email }}</td>
                                            <td>{{ $voluntario->ciudad }}</td>
                                            <td>{{ $voluntario->zona }}</td>
                                            <td>{{ $voluntario->direccion }}</td>
                                            <td>
                                                <form action="{{ route('voluntarios.destroy', $voluntario->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('voluntarios.show', $voluntario->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('voluntarios.edit', $voluntario->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar este voluntario?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $voluntarios->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
