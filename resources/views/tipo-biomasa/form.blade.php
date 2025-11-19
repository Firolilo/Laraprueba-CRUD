<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="tipo_biomasa" class="form-label">{{ __('Tipo de Biomasa') }}</label>
            <input type="text" name="tipo_biomasa" class="form-control @error('tipo_biomasa') is-invalid @enderror" value="{{ old('tipo_biomasa', $tipoBiomasa?->tipo_biomasa) }}" id="tipo_biomasa" placeholder="Ingrese el tipo de biomasa">
            {!! $errors->first('tipo_biomasa', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>
