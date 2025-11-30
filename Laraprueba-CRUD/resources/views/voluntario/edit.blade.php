@extends('layouts.app')

@section('subtitle', 'Editar Voluntario')
@section('content_header_title', 'Voluntarios')
@section('content_header_subtitle', 'Editar')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Editar Voluntario: {{ $voluntario->user->name }}" theme="warning" icon="fas fa-edit">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('voluntarios.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('voluntarios.update', $voluntario->id) }}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('voluntario.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
