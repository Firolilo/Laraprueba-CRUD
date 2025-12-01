<?php if($biomasasFiltradas->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Ubicación</th>
                    <th>Área (m²)</th>
                    <th>Fecha Creación</th>
                    <?php if($estado == 'aprobada'): ?>
                        <th>Aprobada Por</th>
                        <th>Fecha Aprobación</th>
                    <?php endif; ?>
                    <?php if($estado == 'rechazada'): ?>
                        <th>Motivo Rechazo</th>
                        <th>Fecha Rechazo</th>
                    <?php endif; ?>
                    <?php if($estado == 'pendiente'): ?>
                        <th>Acciones</th>
                    <?php else: ?>
                        <th>Detalles</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $biomasasFiltradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $biomasa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($biomasa->id); ?></td>
                        <td>
                            <i class="fas fa-user"></i> 
                            <?php echo e($biomasa->user->name ?? 'N/A'); ?>

                        </td>
                        <td>
                            <strong><?php echo e($biomasa->tipoBiomasa->tipo_biomasa ?? 'Sin tipo'); ?></strong>
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
                            <small><?php echo e($biomasa->created_at->format('d/m/Y H:i')); ?></small>
                        </td>
                        
                        <?php if($estado == 'aprobada'): ?>
                            <td>
                                <i class="fas fa-user-check text-success"></i>
                                <?php echo e($biomasa->aprobadaPor->name ?? 'N/A'); ?>

                            </td>
                            <td>
                                <small><?php echo e($biomasa->fecha_revision?->format('d/m/Y H:i')); ?></small>
                            </td>
                        <?php endif; ?>

                        <?php if($estado == 'rechazada'): ?>
                            <td>
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <?php echo e(Str::limit($biomasa->motivo_rechazo, 50)); ?>

                                </small>
                            </td>
                            <td>
                                <small><?php echo e($biomasa->fecha_revision?->format('d/m/Y H:i')); ?></small>
                            </td>
                        <?php endif; ?>

                        <td>
                            <?php if($estado == 'pendiente'): ?>
                                <div class="btn-group" role="group">
                                    <form action="<?php echo e(route('biomasas.aprobar', $biomasa->id)); ?>" method="POST" style="display:inline;" 
                                          onsubmit="return confirm('¿Está seguro de aprobar esta biomasa?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success btn-sm" title="Aprobar">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                    </form>
                                    
                                    <button onclick="abrirModalRechazo(<?php echo e($biomasa->id); ?>)" 
                                            class="btn btn-danger btn-sm ml-1" title="Rechazar">
                                        <i class="fas fa-ban"></i> Rechazar
                                    </button>
                                    
                                    <a href="<?php echo e(route('biomasas.show', $biomasa->id)); ?>" 
                                       class="btn btn-info btn-sm ml-1" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('biomasas.show', $biomasa->id)); ?>" 
                                       class="btn btn-info btn-sm" title="Ver detalles">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    
                                    <form action="<?php echo e(route('biomasas.destroy', $biomasa->id)); ?>" method="POST" 
                                          style="display:inline;" 
                                          onsubmit="return confirm('¿Está seguro de eliminar esta biomasa? Esta acción no se puede deshacer.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm ml-1" title="Eliminar">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No hay biomasas en estado <strong><?php echo e($estado); ?></strong>.
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/biomasa/partials/lista-biomasas.blade.php ENDPATH**/ ?>