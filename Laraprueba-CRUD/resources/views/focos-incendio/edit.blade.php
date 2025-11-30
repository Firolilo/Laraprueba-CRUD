@extends('layouts.app')

@section('subtitle', 'Editar Foco de Incendio')
@section('content_header_title', 'Focos de Incendio')
@section('content_header_subtitle', 'Editar')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Editar Foco de Incendio: {{ $focosIncendio->ubicacion }}" theme="warning" icon="fas fa-edit">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('focos-incendios.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('focos-incendios.update', $focosIncendio->id) }}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('focos-incendio.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection

@section('css')
    @stack('css')
@endsection

@section('js')
    @stack('js')
@endsection
