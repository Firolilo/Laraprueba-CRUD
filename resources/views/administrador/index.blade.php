@extends('adminlte::page')

@section('template_title')
    Administradores
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Administradores') }}
                            </span>
                             <div class="float-right">
                                <a href="{{ route('administradores.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Departamento</th>
                                        <th>Nivel de Acceso</th>
                                        <th>Activo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($administradores as $administrador)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $administrador->user->name }}</td>
                                            <td>{{ $administrador->user->email }}</td>
                                            <td>{{ $administrador->departamento }}</td>
                                            <td>{{ $administrador->nivel_acceso }}</td>
                                            <td>
                                                @if($administrador->activo)
                                                    <span class="badge badge-success">Sí</span>
                                                @else
                                                    <span class="badge badge-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('administradores.destroy', $administrador->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('administradores.show', $administrador->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('administradores.edit', $administrador->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar este administrador?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $administradores->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
