# Team-Up: Plataforma de Gestión de Actividades Extracurriculares
Materia: Lenguajes de Programación | Periodo: 2026-1 | Estado: Completado

## Equipo de trabajo
- Leonor Molina Zapata ([Leomz21](https://github.com/Leomz21))
- José Andrés Viteri Hoyos ([jvit04](https://github.com/jvit04))
## Equipo de trabajo
- Leonor Molina Zapata - Estudiante 1 ([Leomz21](https://github.com/Leomz21))
- José Andrés Viteri Hoyos - Estudiante 2 ([jvit04](https://github.com/jvit04))

## Capturas / Demo

<img src="docs\screenshots\ie1.png" width="900">

<img src="docs\screenshots\ie2.png" width="900">

<img src="docs\screenshots\ie3.png" width="900">

<img src="docs\screenshots\ie4.png" width="900">

<img src="docs\screenshots\ie5.png" width="900">

<img src="docs\screenshots\ie6.png" width="900">

<img src="docs\screenshots\cc1.png" width="900">

<img src="docs\screenshots\cc2.png" width="900">

<img src="docs\screenshots\cc3.png" width="900">

<img src="docs\screenshots\cc4.png" width="900">

<img src="docs\screenshots\cc5.png" width="900">

<img src="docs\screenshots\cc6.png" width="900">

<img src="docs\screenshots\cc7.png" width="900">

<img src="docs\screenshots\cc8.png" width="900">

<img src="docs\screenshots\cc9.png" width="900">

## Funcionalidad
El sistema se divide en cuatro módulos funcionales principales orientados al ecosistema estudiantil:

## Funcionalidad
- [x] Módulo de Inicio (Muro de Anuncios): Canal de comunicación oficial que funciona como cartelera digital para visualizar de forma cronológica noticias, anuncios destacados y convocatorias urgentes. [Commit](https://github.com/jvit04/TeamUp-UEES/commit/d6315d05ee31258890463823b1bf8d88f639be56)
- [x] Módulo de Concursos y Gestión de Grupos: Espacio dinámico donde los estudiantes pueden explorar competencias disponibles, fundar sus propios grupos o postularse a equipos existentes. Incluye control estricto de cupos máximos y mínimos por concurso. [Commit](https://github.com/jvit04/TeamUp-UEES/commit/4c9be2af07b40e8c26f197a9a2e44d7ed1db6d97)
- [x] Módulo de Clubes Universitarios: Catálogo completo de agrupaciones de la universidad donde los estudiantes rellenan un formulario estructurado (motivo, experiencia y disponibilidad) para solicitar su ingreso. [Commit](https://github.com/jvit04/TeamUp-UEES/commit/fd61fe7be32235b6b3530836d6a21f8ed479ee29)
- [x] Panel de Gestión Descentralizado ("Mis Grupos" / "Mis Clubes"): Interfaces dedicadas para que los líderes de equipos y encargados de clubes administren en tiempo real la aceptación, rechazo o expulsión de miembros. [Commit](https://github.com/jvit04/TeamUp-UEES/commit/fd61fe7be32235b6b3530836d6a21f8ed479ee29)

## Tecnologías
`PHP 8.5` `Laravel 13` `MySQL` `Bootstrap 5` `CSV Flat Files`

## Ejecución
# Instrucciones paso a paso
git clone https://github.com/jvit04/TeamUp-UEES.git
cd TeamUp-UEES

# Instalar dependencias de desarrollo y producción
composer install

# Configurar variables de entorno locales
cp .env.example .env
# Nota: Configure sus credenciales DB_DATABASE, DB_USERNAME y DB_PASSWORD dentro del archivo .env generado.

# Generar clave única de cifrado de la aplicación
php artisan key:generate

# Ejecutar migraciones estructurales y poblar base de datos con Súper Seeder
php artisan migrate:fresh --seed

# Optimizar y limpiar la caché del sistema
php artisan optimize:clear

# Levantar el servidor local
php artisan serve

## Métricas de Progreso
| Indicador | Valor |
| --------- | ----- |
| Commits totales | 49 |
| Issues/PRs fusionados | 0/3 |
| Cobertura de pruebas | 80% |
| Última actualización | 2026-06-13 |

## Reflexión y Aprendizajes
- **Habilidades desarrolladas:** Modelado relacional avanzado de bases de datos, gestión de relaciones complejas de muchos a muchos (`belongsToMany`) e inyección dinámica de estados en vistas Blade.
- **Qué funcionó bien:** La decisión estratégica de dividir las funcionalidades de la plataforma en módulos independientes (inicio/eventos académicos y concursos/clubes), lo que nos permitió avanzar eficientemente en paralelo sin pisar el código del compañero.
- **Qué se podría mejorar:** Desarrollar el sistema completo desde la perspectiva del Administrador General para gestionar dinámicamente las altas y bajas de clubes o concursos, e implementar un sistema de notificaciones automatizadas por correo institucional para alertar a los alumnos cuando sus solicitudes sean aprobadas o rechazadas.
- **Conceptos clave aplicados de la materia:** Aplicación práctica del patrón de diseño Arquitectura Cliente-Servidor, segregación de responsabilidades mediante controladores, abstracción de base de datos con Eloquent ORM y validación estricta de reglas de negocio en el lado del servidor.
