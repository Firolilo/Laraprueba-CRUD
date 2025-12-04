# 🔐 Autenticación con Google - Guía de Configuración

## 📋 Resumen de Cambios

Se ha implementado autenticación OAuth 2.0 con Google en tu aplicación Laravel. Los usuarios ahora pueden iniciar sesión utilizando sus cuentas de Gmail.

### ✅ Cambios Realizados:

1. **Instalado Laravel Socialite** - Paquete oficial de Laravel para autenticación social
2. **Migración para google_id** - Agregada columna a la tabla `users` para almacenar el ID de Google
3. **GoogleController** - Controlador que maneja el flujo de autenticación con Google
4. **Configuración en config/services.php** - Credenciales de Google
5. **Rutas OAuth** - Rutas `/auth/google` y `/auth/google/callback`
6. **Vista de Login Mejorada** - Botón "Sign in with Google" en la pantalla de login

---

## 🚀 Configuración de Google OAuth

### Paso 1: Crear Credenciales en Google Cloud Console

1. Accede a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuevo proyecto (o selecciona uno existente)
3. Ve a **Menú ☰ → APIs y servicios → Credenciales**
4. Haz clic en **"+ Crear Credenciales"** → **OAuth 2.0**
5. Selecciona **Aplicación web** como tipo de aplicación
6. En "Orígenes de JavaScript autorizados", añade:
    ```
    http://localhost:8000
    http://127.0.0.1:8000
    ```
7. En "URI de redirección autorizados", añade:
    ```
    http://localhost:8000/auth/google/callback
    http://127.0.0.1:8000/auth/google/callback
    ```
8. Haz clic en **Crear**
9. Se te mostrará tu **Client ID** y **Client Secret** - cópialos

### Paso 2: Habilitar Google+ API

1. En Google Cloud Console, ve a **Menú ☰ → APIs y servicios → Biblioteca**
2. Busca "Google+ API"
3. Haz clic en ella y presiona **Habilitar**

---

## 🔧 Configurar las Variables de Entorno

### Edita tu archivo `.env`:

```env
# Google OAuth
GOOGLE_CLIENT_ID=tu_client_id_aqui.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=tu_client_secret_aqui
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Reemplaza:**

-   `tu_client_id_aqui` con tu Client ID de Google
-   `tu_client_secret_aqui` con tu Client Secret
-   Ajusta la URL según tu dominio (producción)

---

## 📦 Ejecutar Migraciones

Una vez configurado, ejecuta la migración para añadir la columna `google_id` a la tabla de usuarios:

```bash
php artisan migrate
```

---

## 🎯 Cómo Funciona

### Flujo de Autenticación:

```
Usuario → Clic en "Sign in with Google"
        → Redirige a Google (/auth/google)
        → Usuario aprueba acceso
        → Google redirige a /auth/google/callback
        → El controlador verifica/crea el usuario
        → Usuario inicia sesión automáticamente
        → Redirige al dashboard
```

### Lógica del GoogleController:

1. **Si el google_id ya existe**: Inicia sesión directamente
2. **Si el email existe pero sin google_id**: Vincula la cuenta de Google y inicia sesión
3. **Si es un usuario nuevo**: Crea un nuevo usuario y perfil de Voluntario automáticamente

---

## 👤 Perfiles de Usuario

Cuando un usuario se registra/autentica con Google:

-   Se crea automáticamente como **Voluntario** (rol por defecto)
-   Puede acceder a:
    -   🌿 Gestión de Biomasa
    -   🔥 Simulador (sin guardar)
    -   📊 Consultar Predicciones

---

## 🧪 Prueba la Autenticación

1. Ejecuta tu servidor: `php artisan serve`
2. Accede a `http://localhost:8000/login`
3. Verás el nuevo botón rojo **"Sign in with Google"**
4. Haz clic y verifica que funciona el flujo completo

---

## 🔒 Seguridad

### ✅ Implementado:

-   Las credenciales se guardan en `.env` (no en el repositorio)
-   Laravel Socialite encripta automáticamente las contraseñas
-   Los usuarios de Google obtienen una contraseña aleatoria como fallback
-   El `google_id` es único para evitar duplicados

### 📌 Recomendaciones:

-   Guarda tus credenciales de Google en un lugar seguro
-   Nunca commitees el archivo `.env` a git
-   En producción, usa HTTPS (obligatorio para Google OAuth)
-   Usa variables de entorno diferentes para desarrollo y producción

---

## 📝 Archivos Modificados

```
✅ composer.json                        → Socialite agregado
✅ config/services.php                 → Configuración de Google
✅ routes/web.php                      → Rutas OAuth
✅ resources/views/auth/login.blade.php → Botón Google
✅ app/Http/Controllers/Auth/GoogleController.php → Controlador OAuth
✅ database/migrations/...add_google_id_to_users_table.php → Migración
```

---

## 🐛 Troubleshooting

### Error: "Client ID not found"

-   Verifica que las variables en `.env` están correctamente establecidas
-   Ejecuta `php artisan config:cache` para limpiar caché

### Error: "Invalid redirect URI"

-   Asegúrate que el URI en `.env` coincide exactamente con el registrado en Google Cloud Console
-   Incluye `http://` o `https://`

### El botón no aparece

-   Verifica que estés usando la vista de login personalizada
-   Ejecuta: `php artisan view:clear`

### Usuario no se crea automáticamente

-   Asegúrate que la migración se ejecutó: `php artisan migrate`
-   Verifica que el modelo `Voluntario` existe en `app/Models/Voluntario.php`

---

## 🚀 Próximos Pasos (Opcional)

Puedes extender esto con:

-   **GitHub OAuth**: Añadir `github.redirect` y `github.callback` similar a Google
-   **Microsoft OAuth**: Para usuarios corporativos
-   **2FA**: Autenticación de dos factores adicional
-   **Logout automático**: Después de cierto tiempo de inactividad

---

**¡Tu autenticación con Google está lista! 🎉**
