# Sistema de Autenticación SIPII

## 🔐 Descripción

El sistema SIPII ahora cuenta con autenticación y control de acceso basado en roles. Existen dos tipos de usuarios:

### 👥 Roles del Sistema

#### 🛡️ Administrador
- **Acceso completo** a todos los módulos del sistema
- Puede gestionar:
  - ✅ Usuarios del sistema
  - ✅ Tipos de biomasa
  - ✅ Biomasa (crear, editar, eliminar)
  - ✅ Simulaciones (crear, **guardar**, ver)
  - ✅ Focos de incendio
  - ✅ Predicciones (CRUD completo)
  - ✅ Administradores
  - ✅ Voluntarios

#### 🤝 Voluntario
- **Acceso limitado** a módulos específicos
- Puede:
  - ✅ Crear y gestionar biomasa
  - ✅ Usar el simulador (sin guardar simulaciones)
  - ✅ Consultar predicciones (solo lectura)
  
- **No puede:**
  - ❌ Guardar simulaciones
  - ❌ Gestionar usuarios
  - ❌ Administrar tipos de biomasa
  - ❌ Gestionar focos de incendio
  - ❌ Crear/editar predicciones

---

## 🚀 Credenciales de Prueba

Después de ejecutar `php artisan db:seed`, tendrás dos usuarios de prueba:

### Administrador
```
Email: admin@sipii.com
Password: admin123
```

### Voluntario
```
Email: voluntario@sipii.com
Password: voluntario123
```

---

## 📋 Instrucciones de Uso

### 1️⃣ Primera Vez - Inicializar Base de Datos

```powershell
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (crea usuarios de prueba y tipos de biomasa)
php artisan db:seed
```

### 2️⃣ Iniciar Sesión

1. Accede a `http://localhost:8000/login`
2. Ingresa las credenciales según el rol que desees probar
3. Serás redirigido al dashboard

### 3️⃣ Dashboard Dinámico

El dashboard muestra módulos según tu rol:

**Voluntarios ven:**
- 🍃 Biomasa
- 🔥 Simulador
- 📊 Predicciones

**Administradores ven TODO:**
- 👥 Usuarios
- 🍃 Biomasa
- 📋 Tipos de Biomasa
- 🔥 Simulador
- ▶️ Simulaciones
- 🔥 Focos de Incendio
- 📊 Predicciones
- 🛡️ Administradores
- 🤝 Voluntarios

### 4️⃣ Menú Lateral Filtrado

El menú lateral (sidebar) también se ajusta automáticamente:
- Todos los usuarios ven: Dashboard, Biomasa, Simulador, Predicciones
- **Solo administradores** ven la sección "ADMINISTRACIÓN" con los módulos avanzados

### 5️⃣ Registro de Nuevos Usuarios

Los nuevos usuarios que se registren en `/register` se crearán automáticamente como **Voluntarios**.

Si necesitas crear un administrador, debes hacerlo manualmente desde la base de datos o crear un seeder adicional.

---

## 🔒 Protección de Rutas

Todas las rutas están protegidas con middleware:

```php
// Todas requieren autenticación
Route::middleware('auth')->group(function () {
    
    // Rutas de voluntarios
    Route::middleware('role:voluntario')->group(function () {
        // Biomasa (CRUD completo)
        // Simulador (solo GET, sin guardar)
        // Predicciones (solo index y show)
    });
    
    // Rutas de administradores
    Route::middleware('role:administrador')->group(function () {
        // Acceso a TODO
    });
});
```

### Intentar Acceder Sin Permisos

Si un usuario intenta acceder a una ruta para la que no tiene permisos:
- **Usuario autenticado sin el rol:** Redirige a la página anterior con error 403
- **Usuario no autenticado:** Redirige a `/login`

---

## 🎨 Cambios en el Frontend

### Dashboard (`resources/views/dashboard.blade.php`)
- Muestra badge con el rol del usuario
- Renderiza módulos condicionalmente usando `@if(auth()->user()->isAdministrador())`

### Simulador (`resources/views/simulacione/simulator.blade.php`)
- El modal de "Guardar Simulación" solo se muestra a administradores
- Los voluntarios pueden usar el simulador pero no guardar los resultados

### Menú (`config/adminlte.php`)
- Items con `'can' => 'viewAdmin'` solo son visibles para administradores
- Usa el Gate `viewAdmin` definido en `AppServiceProvider`

---

## 🧪 Probar el Sistema

### Como Administrador:
1. Login con `admin@sipii.com` / `admin123`
2. Verifica que ves TODOS los módulos en el dashboard
3. Accede a "Usuarios" → Deberías poder ver/crear/editar
4. Usa el simulador y verifica que puedes **guardar** simulaciones

### Como Voluntario:
1. Logout (botón en el menú superior derecho)
2. Login con `voluntario@sipii.com` / `voluntario123`
3. Verifica que solo ves: Biomasa, Simulador, Predicciones
4. Intenta acceder manualmente a `/users` → Deberías recibir error 403
5. Usa el simulador y verifica que **NO** aparece el modal de guardar

---

## 📝 Archivos Modificados/Creados

### Autenticación
- ✅ `app/Http/Middleware/CheckRole.php` - Middleware para verificar roles
- ✅ `bootstrap/app.php` - Registro del middleware
- ✅ `app/Http/Controllers/Auth/RegisterController.php` - Auto-creación de Voluntario
- ✅ `app/Http/Controllers/Auth/LoginController.php` - Redirect a dashboard
- ✅ `app/Providers/AppServiceProvider.php` - Gate `viewAdmin`

### Vistas
- ✅ `resources/views/dashboard.blade.php` - Dashboard dinámico por rol
- ✅ `resources/views/simulacione/simulator.blade.php` - Modal de guardar condicional
- ✅ `resources/views/auth/login.blade.php` - Template AdminLTE
- ✅ `resources/views/auth/register.blade.php` - Template AdminLTE

### Configuración
- ✅ `routes/web.php` - Rutas protegidas por rol
- ✅ `config/adminlte.php` - Menú filtrado por rol
- ✅ `database/seeders/DatabaseSeeder.php` - Usuarios de prueba

---

## 🐛 Troubleshooting

### "Class 'Gate' not found"
Asegúrate de tener `use Illuminate\Support\Facades\Gate;` en `AppServiceProvider.php`

### El menú no se filtra correctamente
Verifica que el GateFilter esté habilitado en `config/adminlte.php`:
```php
'filters' => [
    JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    // ... otros filters
],
```

### Error 403 al acceder a rutas
Es normal si estás usando un usuario sin los permisos necesarios. Verifica:
1. Que el usuario tenga el perfil correcto (Administrador o Voluntario)
2. Que la ruta esté en el grupo de middleware correcto

### El modal de guardar aparece a voluntarios
Limpia la caché de vistas:
```powershell
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

---

## 🔄 Migración de Datos Existentes

Si ya tienes usuarios en la base de datos sin perfiles de Administrador o Voluntario:

```php
// Crear manualmente en tinker (php artisan tinker)
$user = User::find(1);

// Crear perfil de administrador
Administrador::create([
    'user_id' => $user->id,
    'departamento' => 'TI',
    'cargo' => 'Administrador',
    'fecha_ingreso' => now(),
]);

// O crear perfil de voluntario
Voluntario::create([
    'user_id' => $user->id,
    'direccion' => 'Dirección',
    'ciudad' => 'Ciudad',
    'zona' => 'Zona',
    'disponibilidad' => true,
]);
```

---

## ✨ Características Adicionales

### Logout
El botón de logout aparece en el menú superior derecho (user menu de AdminLTE)

### Breadcrumbs
Se mantienen los breadcrumbs en todas las vistas para mejor navegación

### Mensajes de Error
- Usuarios no autenticados → Redirige a `/login`
- Usuarios sin permisos → Error 403 con mensaje

---

**¡El sistema está listo para usar! 🎉**
