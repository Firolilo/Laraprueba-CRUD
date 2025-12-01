

<?php $__env->startSection('subtitle', 'Generar Predicción'); ?>
<?php $__env->startSection('content_header_title', 'Predicciones'); ?>
<?php $__env->startSection('content_header_subtitle', 'Generar Nueva Predicción'); ?>

<?php $__env->startSection('content_body'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Nueva Predicción de Propagación','theme' => 'success','icon' => 'fas fa-chart-line'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                     <?php $__env->slot('toolsSlot', null, []); ?> 
                        <a href="<?php echo e(route('predictions.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
                     <?php $__env->endSlot(); ?>

                    <form method="POST" action="<?php echo e(route('predictions.store')); ?>" role="form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo $__env->make('prediction.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </form>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <?php echo $__env->yieldPushContent('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/prediction/create.blade.php ENDPATH**/ ?>