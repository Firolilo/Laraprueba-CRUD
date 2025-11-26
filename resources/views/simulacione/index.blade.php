@extends('adminlte::page')

@section('template_title')
    Simulaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Simulaciones') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('simulaciones.simulator') }}" class="btn btn-success btn-sm mr-2"  data-placement="left">
                                  <i class="fas fa-fire"></i> {{ __('Simulador Avanzado') }}
                                </a>
                                <a href="{{ route('simulaciones.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nueva Simulación') }}
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
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Focos Activos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($simulaciones as $simulacione)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $simulacione->nombre }}</td>
                                            <td>{{ optional($simulacione->fecha)->format('Y-m-d H:i') }}</td>
                                            <td>{{ $simulacione->estado }}</td>
                                            <td>{{ $simulacione->focos_activos }}</td>

                                            <td>
                                                <form action="{{ route('simulaciones.destroy', $simulacione->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('simulaciones.show', $simulacione->id) }}"><i class="fa fa-fw fa-eye"></i> Ver</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('simulaciones.edit', $simulacione->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $simulaciones->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
