<?php $__env->startSection('subtitle', 'Mis Biomasas'); ?>
<?php $__env->startSection('content_header_title', 'Mis Reportes de Biomasa'); ?>
<?php $__env->startSection('content_header_subtitle', 'Gestión Personal'); ?>

<?php $__env->startSection('content_body'); ?>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <a href="<?php echo e(route('biomasas.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Reportar Nueva Biomasa
                </a>
            </div>
        </div>

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

        <?php if($message = Session::get('info')): ?>
            <?php if (isset($component)) { $__componentOriginal9d0273d6550ddf39dc9a547c96729fed = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d0273d6550ddf39dc9a547c96729fed = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Alert::resolve(['theme' => 'info','dismissable' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

        <div class="row">
            <div class="col-12">
                <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Mis Biomasas Reportadas','theme' => 'primary','icon' => 'fas fa-leaf'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    
                    <?php if($biomasas->count() > 0): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Proceso de Revisión:</strong> Tus biomasas serán revisadas por un administrador antes de aparecer en el mapa del sistema.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Ubicación</th>
                                        <th>Área (m²)</th>
                                        <th>Estado</th>
                                        <th>Fecha Reporte</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $biomasas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $biomasa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($biomasa->id); ?></td>
                                            <td>
                                                <span class="badge badge-info">
                                                    <?php echo e($biomasa->tipoBiomasa->tipo_biomasa ?? 'Sin tipo'); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                                <?php if(is_array($biomasa->coordenadas) && count($biomasa->coordenadas) > 0): ?>
                                                    <?php echo e(number_format($biomasa->coordenadas[0][0] ?? 0, 5)); ?>, 
                                                    <?php echo e(number_format($biomasa->coordenadas[0][1] ?? 0, 5)); ?>

                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e(number_format($biomasa->area_m2, 2)); ?></td>
                                            <td>
                                                <?php if($biomasa->estado == 'pendiente'): ?>
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Pendiente
                                                    </span>
                                                <?php elseif($biomasa->estado == 'aprobada'): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle"></i> Aprobada
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times-circle"></i> Rechazada
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small><?php echo e($biomasa->created_at->format('d/m/Y H:i')); ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('biomasas.show', $biomasa->id)); ?>" 
                                                       class="btn btn-info btn-sm" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <?php if($biomasa->estado == 'pendiente'): ?>
                                                        <a href="<?php echo e(route('biomasas.edit', $biomasa->id)); ?>" 
                                                           class="btn btn-warning btn-sm" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <form action="<?php echo e(route('biomasas.destroy', $biomasa->id)); ?>" 
                                                              method="POST" style="display:inline;" 
                                                              onsubmit="return confirm('¿Está seguro de eliminar esta biomasa?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <?php if($biomasa->estado == 'rechazada' && $biomasa->motivo_rechazo): ?>
                                            <tr class="bg-light">
                                                <td colspan="7">
                                                    <div class="alert alert-danger mb-0">
                                                        <strong><i class="fas fa-exclamation-triangle"></i> Motivo de Rechazo:</strong>
                                                        <?php echo e($biomasa->motivo_rechazo); ?>

                                                        <br>
                                                        <small class="text-muted">
                                                            Rechazada el <?php echo e($biomasa->fecha_revision?->format('d/m/Y H:i')); ?>

                                                        </small>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php echo $biomasas->withQueryString()->links(); ?>

                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            No has reportado ninguna biomasa aún. 
                            <a href="<?php echo e(route('biomasas.create')); ?>" class="alert-link">¡Reporta la primera!</a>
                        </div>
                    <?php endif; ?>
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

                <!-- Tarjeta informativa -->
                <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Información sobre Estados','theme' => 'secondary','icon' => 'fas fa-question-circle','collapsible' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <ul>
                        <li>
                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Pendiente</span> - 
                            Tu reporte está en revisión. Puedes editarlo o eliminarlo mientras tanto.
                        </li>
                        <li>
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aprobada</span> - 
                            Tu reporte fue aprobado y ahora aparece en el mapa del sistema.
                        </li>
                        <li>
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Rechazada</span> - 
                            Tu reporte fue rechazado. Revisa el motivo y crea un nuevo reporte si es necesario.
                        </li>
                    </ul>
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


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PROYECTOS\Nueva carpeta\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/biomasa/index.blade.php ENDPATH**/ ?>