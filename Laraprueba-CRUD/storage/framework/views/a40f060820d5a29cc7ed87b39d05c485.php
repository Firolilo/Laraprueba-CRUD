<?php $__env->startSection('subtitle', 'Moderación de Biomasas'); ?>
<?php $__env->startSection('content_header_title', 'Gestión de Biomasas'); ?>
<?php $__env->startSection('content_header_subtitle', '- Moderación y Aprobación'); ?>

<?php $__env->startSection('content_body'); ?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <a href="<?php echo e(route('biomasas.create')); ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Crear Nueva Biomasa
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <?php if($message = Session::get('success')): ?>
                    <?php if (isset($component)) { $__componentOriginal9d0273d6550ddf39dc9a547c96729fed = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d0273d6550ddf39dc9a547c96729fed = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Alert::resolve(['theme' => 'success','dismissable' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Alert::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php echo e($message); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d0273d6550ddf39dc9a547c96729fed)): ?>
<?php $attributes = $__attributesOriginal9d0273d6550ddf39dc9a547c96729fed; ?>
<?php unset($__attributesOriginal9d0273d6550ddf39dc9a547c96729fed); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d0273d6550ddf39dc9a547c96729fed)): ?>
<?php $component = $__componentOriginal9d0273d6550ddf39dc9a547c96729fed; ?>
<?php unset($__componentOriginal9d0273d6550ddf39dc9a547c96729fed); ?>
<?php endif; ?>
                <?php endif; ?>

                <!-- Tabs para filtrar por estado -->
                <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Biomasas Reportadas','theme' => 'primary','icon' => 'fas fa-leaf'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#pendientes">
                                <i class="fas fa-clock"></i> Pendientes 
                                <span class="badge badge-warning"><?php echo e($biomasas->where('estado', 'pendiente')->count()); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#aprobadas">
                                <i class="fas fa-check-circle"></i> Aprobadas 
                                <span class="badge badge-success"><?php echo e($biomasas->where('estado', 'aprobada')->count()); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#rechazadas">
                                <i class="fas fa-times-circle"></i> Rechazadas 
                                <span class="badge badge-danger"><?php echo e($biomasas->where('estado', 'rechazada')->count()); ?></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- PENDIENTES -->
                        <div id="pendientes" class="tab-pane fade show active">
                            <?php echo $__env->make('biomasa.partials.lista-biomasas', ['biomasasFiltradas' => $biomasas->where('estado', 'pendiente'), 'estado' => 'pendiente'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>

                        <!-- APROBADAS -->
                        <div id="aprobadas" class="tab-pane fade">
                            <?php echo $__env->make('biomasa.partials.lista-biomasas', ['biomasasFiltradas' => $biomasas->where('estado', 'aprobada'), 'estado' => 'aprobada'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>

                        <!-- RECHAZADAS -->
                        <div id="rechazadas" class="tab-pane fade">
                            <?php echo $__env->make('biomasa.partials.lista-biomasas', ['biomasasFiltradas' => $biomasas->where('estado', 'rechazada'), 'estado' => 'rechazada'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>

                    <?php echo $biomasas->withQueryString()->links(); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $attributes = $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $component = $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para rechazar -->
    <?php if (isset($component)) { $__componentOriginale2dfb698641700bc6575e0f9f2d3d632 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2dfb698641700bc6575e0f9f2d3d632 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Tool\Modal::resolve(['id' => 'modalRechazar','title' => 'Motivo de Rechazo','theme' => 'danger','icon' => 'fas fa-ban'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Tool\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <form id="formRechazar" method="POST">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginala47f947a90f7125ced2d0aa2e9c7c7d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala47f947a90f7125ced2d0aa2e9c7c7d7 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Textarea::resolve(['name' => 'motivo_rechazo','label' => 'Motivo del Rechazo'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rows' => '4','placeholder' => 'Explique por qué se rechaza esta biomasa...','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala47f947a90f7125ced2d0aa2e9c7c7d7)): ?>
<?php $attributes = $__attributesOriginala47f947a90f7125ced2d0aa2e9c7c7d7; ?>
<?php unset($__attributesOriginala47f947a90f7125ced2d0aa2e9c7c7d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala47f947a90f7125ced2d0aa2e9c7c7d7)): ?>
<?php $component = $__componentOriginala47f947a90f7125ced2d0aa2e9c7c7d7; ?>
<?php unset($__componentOriginala47f947a90f7125ced2d0aa2e9c7c7d7); ?>
<?php endif; ?>
             <?php $__env->slot('footerSlot', null, []); ?> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-ban"></i> Rechazar Biomasa
                </button>
             <?php $__env->endSlot(); ?>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2dfb698641700bc6575e0f9f2d3d632)): ?>
<?php $attributes = $__attributesOriginale2dfb698641700bc6575e0f9f2d3d632; ?>
<?php unset($__attributesOriginale2dfb698641700bc6575e0f9f2d3d632); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2dfb698641700bc6575e0f9f2d3d632)): ?>
<?php $component = $__componentOriginale2dfb698641700bc6575e0f9f2d3d632; ?>
<?php unset($__componentOriginale2dfb698641700bc6575e0f9f2d3d632); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    function abrirModalRechazo(biomasaId) {
        const form = document.getElementById('formRechazar');
        form.action = `/biomasas/${biomasaId}/rechazar`;
        $('#modalRechazar').modal('show');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/biomasa/admin-index.blade.php ENDPATH**/ ?>