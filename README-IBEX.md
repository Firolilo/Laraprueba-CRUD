Uso de modelos con ibex/crud-generator

He creado los modelos necesarios para que puedas generar los CRUDs con ibex:

- `App\Models\User`          (campos: nombre, apellido, email, cedula_identidad, telefono, password, rol)
- `App\Models\Biomasa`       (fecha_observacion, tipo_biomasa, estado_conservacion, densidad_vegetacion, area, delimitacion_area (array), observaciones)
- `App\Models\Simulacion`    (fecha, nombre, duracion, focos_activos, num_voluntarios_enviados)
- `App\Models\FocoIncendio` (fecha, ubicacion, coordenadas (array), intensidad)

Notas importantes:

- Los campos JSON/Array están definidos con casts (`delimitacion_area`, `coordenadas`). Asegúrate de que las columnas de la base de datos sean de tipo `json` o `text` y que ibex genere migraciones apropiadas.
- Si ibex espera campos con nombres en inglés, adapta los nombres de los atributos o pasa las opciones de ibex para mapearlos.
- Para generar los CRUDs con ibex, normalmente se ejecuta el comando del generador (ejemplo):

  php artisan ibex:crud User --model=App\\Models\\User

  (ajusta el comando según la sintaxis exacta del paquete `ibex/crud-generator`).

- Si necesitas que genere también migraciones, controladores o recursos con opciones específicas, dime qué prefieres y los puedo añadir o preparar aquí.

Siguiente paso sugerido:

- Ejecuta el comando de ibex en tu entorno local para generar los CRUDs. Si aparece algún error (migraciones, campos faltantes, casting), pégame la salida y lo resolvemos.
