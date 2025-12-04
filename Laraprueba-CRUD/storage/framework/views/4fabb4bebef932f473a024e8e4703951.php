<?php $__env->startSection('subtitle', 'Predicciones'); ?>
<?php $__env->startSection('content_header_title', 'Predicciones de Propagación'); ?>
<?php $__env->startSection('content_header_subtitle', '- Listado'); ?>

<?php $__env->startSection('content_body'); ?>
    <div class="container-fluid">
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

                <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Predicciones','theme' => 'purple','icon' => 'fas fa-chart-line'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                     <?php $__env->slot('toolsSlot', null, []); ?> 
                        <a href="<?php echo e(route('predictions.create')); ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Generar Predicción
                        </a>
                     <?php $__env->endSlot(); ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foco de Incendio</th>
                                    <th>Fecha de Predicción</th>
                                    <th>Horas</th>
                                    <th>Riesgo</th>
                                    <th>Área Afectada</th>
                                    <th>Puntos</th>
                                    <th style="width: 180px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $predictions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prediction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $meta = $prediction->meta ?? [];
                                        $riesgo = $meta['fire_risk_index'] ?? 0;
                                        $area = $meta['total_area_affected_km2'] ?? 0;
                                        $horas = $meta['input_parameters']['prediction_hours'] ?? 0;
                                    ?>
                                    <tr>
                                        <td><?php echo e(++$i); ?></td>
                                        <td>
                                            <?php if($prediction->focoIncendio): ?>
                                                <strong><?php echo e($prediction->focoIncendio->ubicacion ?? 'N/A'); ?></strong><br>
                                                <small class="text-muted"><?php echo e($prediction->focoIncendio->fecha?->format('d/m/Y')); ?></small>
                                            <?php else: ?>
                                                <strong><i class="fas fa-satellite text-info"></i> Foco FIRMS</strong><br>
                                                <small class="text-muted"><?php echo e($prediction->predicted_at?->format('d/m/Y')); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($prediction->predicted_at?->format('d/m/Y H:i') ?? 'N/A'); ?></td>
                                        <td><?php echo e($horas); ?>h</td>
                                        <td>
                                            <span class="badge badge-<?php echo e($riesgo > 70 ? 'danger' : ($riesgo > 40 ? 'warning' : 'info')); ?>">
                                                <?php echo e($riesgo); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e(number_format($area, 2)); ?> km²</td>
                                        <td><?php echo e(is_array($prediction->path) ? count($prediction->path) : 0); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo e(route('predictions.show', $prediction->id)); ?>" class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('predictions.pdf', $prediction->id)); ?>" class="btn btn-primary btn-sm" title="Ver Informe" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <form action="<?php echo e(route('predictions.destroy', $prediction->id)); ?>" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Estás seguro de eliminar?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo $predictions->withQueryString()->links(); ?>

                    </div>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PROYECTOS\Nueva carpeta\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/prediction/index.blade.php ENDPATH**/ ?>