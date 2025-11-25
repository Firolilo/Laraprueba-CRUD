<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Nombre') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $administrador->user->name ?? '') }}" id="name" placeholder="Nombre completo" required>
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $administrador->user->email ?? '') }}" id="email" placeholder="email@example.com" required>
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="password" class="form-label">{{ __('Contraseña') }} @if($administrador->exists)<small class="text-muted">(dejar en blanco para mantener la actual)</small>@else<span class="text-danger">*</span>@endif</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="********" @if(!$administrador->exists) required @endif>
            {!! $errors->first('password', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }} @if($administrador->exists)<small class="text-muted">(dejar en blanco para mantener la actual)</small>@else<span class="text-danger">*</span>@endif</label>
            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="********" @if(!$administrador->exists) required @endif>
            {!! $errors->first('password_confirmation', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <hr>

        <div class="form-group mb-2 mb20">
            <label for="departamento" class="form-label">{{ __('Departamento') }} <span class="text-danger">*</span></label>
            <input type="text" name="departamento" class="form-control @error('departamento') is-invalid @enderror" value="{{ old('departamento', $administrador?->departamento) }}" id="departamento" placeholder="Ej: Sistemas, Operaciones, etc." required>
            {!! $errors->first('departamento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="nivel_acceso" class="form-label">{{ __('Nivel de Acceso (1-5)') }} <span class="text-danger">*</span></label>
            <input type="number" name="nivel_acceso" class="form-control @error('nivel_acceso') is-invalid @enderror" value="{{ old('nivel_acceso', $administrador?->nivel_acceso ?? 1) }}" id="nivel_acceso" min="1" max="5" required>
            {!! $errors->first('nivel_acceso', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            <small class="form-text text-muted">1 = Bajo, 5 = Máximo</small>
        </div>

        <div class="form-group mb-2 mb20">
            <div class="form-check">
                <input type="checkbox" name="activo" class="form-check-input" id="activo" value="1" {{ old('activo', $administrador?->activo ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo">
                    {{ __('Activo') }}
                </label>
            </div>
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        <a href="{{ route('administradores.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
    </div>
</div>
