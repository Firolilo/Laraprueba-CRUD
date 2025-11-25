<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Nombre') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $voluntario->user->name ?? '') }}" id="name" placeholder="Nombre completo" required>
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $voluntario->user->email ?? '') }}" id="email" placeholder="email@example.com" required>
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="password" class="form-label">{{ __('Contraseña') }} @if($voluntario->exists)<small class="text-muted">(dejar en blanco para mantener la actual)</small>@else<span class="text-danger">*</span>@endif</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="********" @if(!$voluntario->exists) required @endif>
            {!! $errors->first('password', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }} @if($voluntario->exists)<small class="text-muted">(dejar en blanco para mantener la actual)</small>@else<span class="text-danger">*</span>@endif</label>
            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="********" @if(!$voluntario->exists) required @endif>
            {!! $errors->first('password_confirmation', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <hr>

        <div class="form-group mb-2 mb20">
            <label for="direccion" class="form-label">{{ __('Dirección') }} <span class="text-danger">*</span></label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $voluntario?->direccion) }}" id="direccion" placeholder="Calle, número, etc." required>
            {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="ciudad" class="form-label">{{ __('Ciudad') }} <span class="text-danger">*</span></label>
            <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror" value="{{ old('ciudad', $voluntario?->ciudad) }}" id="ciudad" placeholder="Nombre de la ciudad" required>
            {!! $errors->first('ciudad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="zona" class="form-label">{{ __('Zona') }} <span class="text-danger">*</span></label>
            <input type="text" name="zona" class="form-control @error('zona') is-invalid @enderror" value="{{ old('zona', $voluntario?->zona) }}" id="zona" placeholder="Zona o barrio" required>
            {!! $errors->first('zona', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="notas" class="form-label">{{ __('Notas') }}</label>
            <textarea name="notas" class="form-control @error('notas') is-invalid @enderror" id="notas" rows="3" placeholder="Información adicional (opcional)">{{ old('notas', $voluntario?->notas) }}</textarea>
            {!! $errors->first('notas', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        <a href="{{ route('voluntarios.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
    </div>
</div>
