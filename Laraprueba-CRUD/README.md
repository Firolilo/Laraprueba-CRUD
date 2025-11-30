# SIPII - Panel Web de Administración

Sistema de administración web para gestión de incendios forestales con interfaz AdminLTE.

## ⚠️ Importante

**Esta aplicación es SOLO el panel web administrativo.**

Para la API REST que usa la app móvil, ver: `../sipii-api/`

## 🚀 Inicio Rápido

```bash
cd "C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD"
php artisan serve --port=8000
```

Acceder en: **http://localhost:8000**

## Características Principales

### 🔥 Simulador Avanzado de Incendios
- **Simulación en tiempo real** de propagación de incendios
- **Mapa interactivo Leaflet** para colocación de focos
- **Algoritmo probabilístico** de propagación basado en riesgo
- **Parámetros dinámicos**: temperatura, humedad, viento
- **Cálculo automático** de riesgo y voluntarios necesarios
- **Historial completo** guardado en base de datos

### 📊 Módulos CRUD
- **Usuarios**: Gestión de usuarios del sistema
- **Voluntarios**: Registro de voluntarios
- **Administradores**: Gestión de administradores
- **Biomasas**: Delimitación de áreas de biomasa
- **Tipos de Biomasa**: Catálogo paramétrico
- **Focos de Incendio**: Seguimiento de focos
- **Simulaciones**: Gestión de simulaciones
- **Predicciones**: Rutas de propagación

### 🗄️ Base de Datos
- **PostgreSQL** con esquema normalizado
- **Tablas relacionales** con foreign keys
- **JSON columns** para datos complejos (historial, estrategias)
- **Pivot tables** para relaciones many-to-many
- **Soft deletes** donde corresponde

## Tecnologías

- **Backend**: Laravel 12.37.0, PHP 8.2.12
- **Frontend**: AdminLTE 3.x, Alpine.js 3.x, Blade
- **Mapas**: Leaflet.js 1.9.4
- **Base de datos**: PostgreSQL
- **CRUD Generator**: ibex/crud-generator

## Instalación

```bash
# Clonar repositorio
git clone https://github.com/Firolilo/Laraprueba-CRUD.git
cd Laraprueba-CRUD

# Instalar dependencias
composer install
npm install

# Configurar .env
cp .env.example .env
php artisan key:generate

# Configurar base de datos en .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nombre_bd
DB_USERNAME=usuario
DB_PASSWORD=contraseña

# Migrar base de datos
php artisan migrate

# Servir aplicación
php artisan serve
```

## Uso del Simulador

1. Accede a `/simulaciones/simulator`
2. Click en el mapa para añadir focos iniciales
3. Ajusta parámetros ambientales (temperatura, humedad, viento)
4. Click "Iniciar Simulación"
5. Observa la propagación en tiempo real
6. Detén y guarda la simulación

Ver documentación detallada en [SIMULADOR.md](SIMULADOR.md)

## Estructura del Proyecto

```
app/
├── Http/Controllers/    # Controladores CRUD + Simulator
├── Models/             # Eloquent models
└── Providers/          # Service providers

database/
├── migrations/         # Schema migrations
└── seeders/           # Database seeders

resources/
├── views/
│   ├── simulacione/   # Vistas de simulaciones
│   ├── biomasa/       # Vistas de biomasa
│   └── ...
└── js/                # Alpine.js components

routes/
└── web.php           # Rutas de la aplicación
```

## Contribución

Las contribuciones son bienvenidas. Por favor, abre un issue primero para discutir cambios mayores.

## Licencia

Este proyecto es de código abierto bajo licencia MIT.

---

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
