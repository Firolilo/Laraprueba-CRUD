@extends('adminlte::page')

@section('template_title')
    {{ $administrador->user->name ?? __('Ver') . " Administrador" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Administrador</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('administradores.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $administrador->user->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Email:</strong>
                            {{ $administrador->user->email }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Departamento:</strong>
                            {{ $administrador->departamento }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nivel de Acceso:</strong>
                            {{ $administrador->nivel_acceso }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Activo:</strong>
                            @if($administrador->activo)
                                <span class="badge badge-success">Sí</span>
                            @else
                                <span class="badge badge-secondary">No</span>
                            @endif
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Creado:</strong>
                            {{ $administrador->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Actualizado:</strong>
                            {{ $administrador->updated_at->format('d/m/Y H:i') }}
                        </div>

                        @if($administrador->simulaciones->count() > 0)
                        <hr>
                        <h5>Simulaciones creadas ({{ $administrador->simulaciones->count() }})</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Duración</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($administrador->simulaciones as $sim)
                                    <tr>
                                        <td>{{ $sim->nombre }}</td>
                                        <td>{{ $sim->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $sim->duracion }}h</td>
                                        <td>{{ $sim->estado }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
