<div class="row padding-1 p-1">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="fecha">Fecha</label>
            <input type="datetime-local" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', optional($focosIncendio->fecha)->format('Y-m-d\TH:i')) }}">
            @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="ubicacion">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion', $focosIncendio->ubicacion) }}">
            @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="intensidad">Intensidad</label>
            <input type="number" step="0.01" name="intensidad" id="intensidad" class="form-control @error('intensidad') is-invalid @enderror" value="{{ old('intensidad', $focosIncendio->intensidad) }}">
            @error('intensidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="coordenadas">Coordenadas [lat, lng]</label>
            <input type="text" name="coordenadas" id="coordenadas" class="form-control @error('coordenadas') is-invalid @enderror" value="{{ old('coordenadas', $focosIncendio->coordenadas ? json_encode($focosIncendio->coordenadas) : '') }}" placeholder='[ -16.5, -68.15 ]'>
            @error('coordenadas')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>