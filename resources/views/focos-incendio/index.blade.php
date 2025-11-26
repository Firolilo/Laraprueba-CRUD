@extends('adminlte::page')

@section('template_title')
    Focos de Incendios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Focos Incendios') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('focos-incendios.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Fecha</th>
                                        <th>Ubicación</th>
                                        <th>Coordenadas</th>
                                        <th>Intensidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($focosIncendios as $focosIncendio)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ optional($focosIncendio->fecha)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $focosIncendio->ubicacion }}</td>
                                            <td>
                                                @if($focosIncendio->coordenadas)
                                                    <small class="text-muted">
                                                        Lat: {{ $focosIncendio->coordenadas[0] }}<br>
                                                        Lng: {{ $focosIncendio->coordenadas[1] }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $focosIncendio->intensidad > 7 ? 'danger' : ($focosIncendio->intensidad > 4 ? 'warning' : 'info') }}">
                                                    {{ $focosIncendio->intensidad }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('focos-incendios.destroy', $focosIncendio->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('focos-incendios.show', $focosIncendio->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('focos-incendios.edit', $focosIncendio->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar este foco?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $focosIncendios->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
