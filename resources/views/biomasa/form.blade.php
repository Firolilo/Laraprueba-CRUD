<div class="row padding-1 p-1">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $biomasa->nombre) }}" required>
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="tipo_biomasa_id">Tipo de Biomasa</label>
            <select name="tipo_biomasa_id" id="tipo_biomasa_id" class="form-control @error('tipo_biomasa_id') is-invalid @enderror">
                <option value="">Seleccione un tipo</option>
                @foreach($tipoBiomasas as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_biomasa_id', $biomasa->tipo_biomasa_id) == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->tipo_biomasa }}
                    </option>
                @endforeach
            </select>
            @error('tipo_biomasa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="area_m2">Área (m²)</label>
            <input type="number" name="area_m2" id="area_m2" class="form-control @error('area_m2') is-invalid @enderror" value="{{ old('area_m2', $biomasa->area_m2) }}" min="0">
            @error('area_m2')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="densidad">Densidad</label>
            <input type="number" step="0.01" name="densidad" id="densidad" class="form-control @error('densidad') is-invalid @enderror" value="{{ old('densidad', $biomasa->densidad) }}">
            @error('densidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="humedad">Humedad (%)</label>
            <input type="number" step="0.01" name="humedad" id="humedad" class="form-control @error('humedad') is-invalid @enderror" value="{{ old('humedad', $biomasa->humedad) }}">
            @error('humedad')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="ubicacion">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion', $biomasa->ubicacion) }}">
            @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $biomasa->descripcion) }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>