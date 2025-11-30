@extends('layouts.app')

@section('subtitle', 'Editar Usuario')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Editar')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Editar Usuario: {{ $user->name }}" theme="warning" icon="fas fa-user-edit">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('users.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('users.update', $user->id) }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @include('user.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
