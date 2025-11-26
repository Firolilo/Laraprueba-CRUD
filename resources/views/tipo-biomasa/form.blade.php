<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="tipo_biomasa" class="form-label">{{ __('Tipo de Biomasa') }}</label>
            <input type="text" name="tipo_biomasa" class="form-control @error('tipo_biomasa') is-invalid @enderror" value="{{ old('tipo_biomasa', $tipoBiomasa?->tipo_biomasa) }}" id="tipo_biomasa" placeholder="Ej: Bosque, Sabana, Pastizal" required>
            {!! $errors->first('tipo_biomasa', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="color" class="form-label"><i class="fas fa-palette"></i> {{ __('Color de Identificación') }}</label>
            <div class="input-group">
                <input type="color" name="color" class="form-control form-control-color @error('color') is-invalid @enderror" value="{{ old('color', $tipoBiomasa?->color ?? '#4CAF50') }}" id="color" title="Seleccione un color">
                <input type="text" class="form-control" id="colorHex" value="{{ old('color', $tipoBiomasa?->color ?? '#4CAF50') }}" readonly>
            </div>
            <small class="form-text text-muted">Este color se usará para mostrar este tipo de biomasa en el mapa</small>
            {!! $errors->first('color', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="modificador_intensidad" class="form-label">
                <i class="fas fa-fire"></i> {{ __('Modificador de Intensidad de Fuego') }}
            </label>
            <div class="row align-items-center">
                <div class="col-8">
                    <input type="range" 
                           name="modificador_intensidad" 
                           class="form-range @error('modificador_intensidad') is-invalid @enderror" 
                           value="{{ old('modificador_intensidad', $tipoBiomasa?->modificador_intensidad ?? 1.0) }}" 
                           id="modificador_intensidad" 
                           min="0.5" 
                           max="2.0" 
                           step="0.1"
                           oninput="updateModifierDisplay(this.value)">
                </div>
                <div class="col-4">
                    <div class="input-group">
                        <input type="number" 
                               class="form-control" 
                               id="modifierDisplay" 
                               value="{{ old('modificador_intensidad', $tipoBiomasa?->modificador_intensidad ?? 1.0) }}" 
                               min="0.5" 
                               max="2.0" 
                               step="0.1"
                               onchange="updateModifierSlider(this.value)">
                        <span class="input-group-text">x</span>
                    </div>
                </div>
            </div>
            <small class="form-text text-muted">
                Define qué tan rápido se propaga el fuego en este tipo de biomasa. 
                <strong>0.5x</strong> = Muy lento (rocoso), 
                <strong>1.0x</strong> = Normal, 
                <strong>2.0x</strong> = Muy rápido (bosque seco)
            </small>
            {!! $errors->first('modificador_intensidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    
    <div class="col-md-12 mt20 mt-3">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save"></i> {{ __('Guardar Tipo de Biomasa') }}
        </button>
        <a href="{{ route('tipo-biomasas.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</div>

@push('js')
<script>
    // Sincronizar color picker con input de texto
    document.getElementById('color').addEventListener('input', function(e) {
        document.getElementById('colorHex').value = e.target.value;
    });
    
    // Actualizar display del modificador desde el slider
    function updateModifierDisplay(value) {
        document.getElementById('modifierDisplay').value = parseFloat(value).toFixed(1);
    }
    
    // Actualizar slider desde el input numérico
    function updateModifierSlider(value) {
        document.getElementById('modificador_intensidad').value = value;
    }
</script>
@endpush
