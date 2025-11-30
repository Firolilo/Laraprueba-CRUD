@extends('layouts.app')

@section('subtitle', 'Ver Voluntario')
@section('content_header_title', 'Voluntarios')
@section('content_header_subtitle', 'Detalle')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Información del Voluntario: {{ $voluntario->user->name }}" theme="info" icon="fas fa-hands-helping">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('voluntarios.index') }}"/>
                        <x-adminlte-button label="Editar" icon="fas fa-edit" 
                            class="btn-sm" theme="warning" href="{{ route('voluntarios.edit', $voluntario->id) }}"/>
                    </x-slot>

                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-callout theme="teal" title="Nombre">
                                {{ $voluntario->user->name }}
                            </x-adminlte-callout>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-callout theme="info" title="Email">
                                {{ $voluntario->user->email }}
                            </x-adminlte-callout>
                        </div>
                        <div class="col-md-12">
                            <x-adminlte-callout theme="success" title="Dirección">
                                {{ $voluntario->direccion }}
                            </x-adminlte-callout>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-callout theme="primary" title="Ciudad">
                                {{ $voluntario->ciudad }}
                            </x-adminlte-callout>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-callout theme="warning" title="Zona">
                                {{ $voluntario->zona }}
                            </x-adminlte-callout>
                        </div>
                        @if($voluntario->notas)
                        <div class="col-md-12">
                            <x-adminlte-callout theme="light" title="Notas">
                                {{ $voluntario->notas }}
                            </x-adminlte-callout>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <x-adminlte-callout theme="secondary" title="Fechas">
                                <strong>Creado:</strong> {{ $voluntario->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Actualizado:</strong> {{ $voluntario->updated_at->format('d/m/Y H:i') }}
                            </x-adminlte-callout>
                        </div>
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
