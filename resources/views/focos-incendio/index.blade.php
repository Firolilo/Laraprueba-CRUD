@extends('adminlte::page')

@section('template_title')
    Focos Incendios
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
                                        <th>Fecha</th>
                                        <th>Ubicación</th>
                                        <th>Intensidad</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($focosIncendios as $focosIncendio)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ optional($focosIncendio->fecha)->format('Y-m-d H:i') }}</td>
                                            <td>{{ $focosIncendio->ubicacion }}</td>
                                            <td>{{ $focosIncendio->intensidad }}</td>

                                            <td>
                                                <form action="{{ route('focos-incendios.destroy', $focosIncendio->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('focos-incendios.show', $focosIncendio->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('focos-incendios.edit', $focosIncendio->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $focosIncendios->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
