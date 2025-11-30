@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
    <div class="float-right">
        Versión: {{ config('app.version', '1.0.0') }}
    </div>

    <strong>
        Copyright &copy; {{ date('Y') }}
        <a href="{{ config('app.url', '#') }}">
            SIPII - Sistema de Prevención de Incendios
        </a>
    </strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>
    $(document).ready(function() {
        // Configuración global de DataTables en español
        if ($.fn.DataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });
        }

        // Configuración global de SweetAlert2
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            window.Toast = Toast;
        }
    });
</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">
    /* Mejoras visuales para cards */
    .card-header {
        font-weight: 600;
    }
    
    /* Mejoras para tablas */
    .table thead th {
        vertical-align: middle;
    }
    
    /* Botones de acción en tablas */
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush
