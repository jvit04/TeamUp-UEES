<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $adminRolId = DB::table('roles')->insertGetId([
            'nombre_rol' => 'Administrador',
            'descripcion' => 'Usuario con permisos para administrar publicaciones, concursos, clubes y eventos académicos.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $estudianteRolId = DB::table('roles')->insertGetId([
            'nombre_rol' => 'Estudiante',
            'descripcion' => 'Usuario estudiante que puede visualizar publicaciones, postular a clubes y participar en concursos.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Usuarios
        |--------------------------------------------------------------------------
        */

        $adminId = DB::table('users')->insertGetId([
            'id_rol' => $adminRolId,
            'nombres' => 'Administrador',
            'apellidos' => 'UEES',
            'correo_institucional' => 'admin@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Administración Académica',
            'telefono' => '0999999999',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $joseId = DB::table('users')->insertGetId([
            'id_rol' => $estudianteRolId,
            'nombres' => 'José Andrés',
            'apellidos' => 'Viteri Hoyos',
            'correo_institucional' => 'jviteri@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Ingeniería en Computación',
            'telefono' => '0988888888',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $leonorId = DB::table('users')->insertGetId([
            'id_rol' => $estudianteRolId,
            'nombres' => 'Leonor',
            'apellidos' => 'Molina Zapata',
            'correo_institucional' => 'lmolina@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Ingeniería en Computación',
            'telefono' => '0977777777',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // --- NUEVOS USUARIOS ---
        $mariaId = DB::table('users')->insertGetId([
            'id_rol' => $estudianteRolId,
            'nombres' => 'María',
            'apellidos' => 'Gómez',
            'correo_institucional' => 'mgomez@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Mecatrónica',
            'telefono' => '0966666666',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $carlosId = DB::table('users')->insertGetId([
            'id_rol' => $estudianteRolId,
            'nombres' => 'Carlos',
            'apellidos' => 'Ruiz',
            'correo_institucional' => 'cruiz@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Derecho',
            'telefono' => '0955555555',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $anaId = DB::table('users')->insertGetId([
            'id_rol' => $estudianteRolId,
            'nombres' => 'Ana',
            'apellidos' => 'Torres',
            'correo_institucional' => 'atorres@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Sistemas',
            'telefono' => '0944444444',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $luisId = DB::table('users')->insertGetId([
            'id_rol' => $estudianteRolId,
            'nombres' => 'Luis',
            'apellidos' => 'Castro',
            'correo_institucional' => 'lcastro@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Sistemas',
            'telefono' => '0933333333',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pedroId = DB::table('users')->insertGetId([
            'id_rol' => $estudianteRolId,
            'nombres' => 'Pedro',
            'apellidos' => 'Vera',
            'correo_institucional' => 'pvera@uees.edu.ec',
            'password' => Hash::make('password123'),
            'carrera' => 'Sistemas',
            'telefono' => '0922222222',
            'estado_usuario' => 'ACTIVO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Publicaciones compartidas para el inicio/dashboard
        |--------------------------------------------------------------------------
        */

        $pubConcurso1 = DB::table('publicaciones')->insertGetId([
            'id_usuario' => $adminId,
            'titulo' => 'SpaceHack 2026: Mitigación de Inundaciones',
            'descripcion' => 'Hackathon académico enfocado en soluciones tecnológicas con datos satelitales para prevenir riesgos ambientales.',
            'imagen' => 'img/publicaciones/spacehack-2026.svg',
            'tipo_publicacion' => 'CONCURSO',
            'fecha_publicacion' => Carbon::today()->toDateString(),
            'estado_publicacion' => 'PUBLICADA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pubConcurso2 = DB::table('publicaciones')->insertGetId([
            'id_usuario' => $adminId,
            'titulo' => 'Reto de Innovación Social UEES',
            'descripcion' => 'Concurso para equipos multidisciplinarios que propongan soluciones de impacto social usando tecnología, diseño y emprendimiento.',
            'imagen' => 'img/publicaciones/reto-innovacion-social.svg',
            'tipo_publicacion' => 'CONCURSO',
            'fecha_publicacion' => Carbon::today()->toDateString(),
            'estado_publicacion' => 'PUBLICADA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pubClub1 = DB::table('publicaciones')->insertGetId([
            'id_usuario' => $adminId,
            'titulo' => 'Club de Robótica e Inteligencia Artificial',
            'descripcion' => 'Espacio para estudiantes interesados en robótica, automatización, visión artificial e inteligencia artificial aplicada.',
            'imagen' => 'img/publicaciones/club-robotica-ia.svg',
            'tipo_publicacion' => 'CLUB',
            'fecha_publicacion' => Carbon::today()->toDateString(),
            'estado_publicacion' => 'PUBLICADA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pubClub2 = DB::table('publicaciones')->insertGetId([
            'id_usuario' => $adminId,
            'titulo' => 'Club de Debate y Liderazgo',
            'descripcion' => 'Club universitario orientado a fortalecer comunicación, pensamiento crítico, liderazgo y participación estudiantil.',
            'imagen' => 'img/publicaciones/club-debate-liderazgo.svg',
            'tipo_publicacion' => 'CLUB',
            'fecha_publicacion' => Carbon::today()->toDateString(),
            'estado_publicacion' => 'PUBLICADA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pubEvento1 = DB::table('publicaciones')->insertGetId([
            'id_usuario' => $adminId,
            'titulo' => 'Conferencia: Ciberseguridad en Entornos Universitarios',
            'descripcion' => 'Charla informativa sobre protección de datos, contraseñas seguras, ingeniería social y buenas prácticas digitales.',
            'imagen' => 'img/publicaciones/ciberseguridad-campus.svg',
            'tipo_publicacion' => 'EVENTO_ACADEMICO',
            'fecha_publicacion' => Carbon::today()->toDateString(),
            'estado_publicacion' => 'PUBLICADA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pubEvento2 = DB::table('publicaciones')->insertGetId([
            'id_usuario' => $adminId,
            'titulo' => 'Taller: Diseño UX para Aplicaciones Web',
            'descripcion' => 'Taller práctico sobre experiencia de usuario, prototipado, arquitectura de información y diseño de interfaces.',
            'imagen' => 'img/publicaciones/taller-ux.svg',
            'tipo_publicacion' => 'EVENTO_ACADEMICO',
            'fecha_publicacion' => Carbon::today()->toDateString(),
            'estado_publicacion' => 'PUBLICADA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pubEvento3 = DB::table('publicaciones')->insertGetId([
            'id_usuario' => $adminId,
            'titulo' => 'Seminario: Inteligencia Artificial Aplicada',
            'descripcion' => 'Seminario académico sobre casos de uso de IA en educación, salud, empresas y proyectos universitarios.',
            'imagen' => 'img/publicaciones/seminario-ia.svg',
            'tipo_publicacion' => 'EVENTO_ACADEMICO',
            'fecha_publicacion' => Carbon::today()->toDateString(),
            'estado_publicacion' => 'PUBLICADA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Concursos
        |--------------------------------------------------------------------------
        */

        $concursoSpaceHackId = DB::table('concursos')->insertGetId([
            'id_publicacion' => $pubConcurso1,
            'nombre_concurso' => 'SpaceHack 2026: Mitigación de Inundaciones',
            'descripcion_concurso' => 'Hackathon enfocada en el uso de datos satelitales para prevenir inundaciones y proponer soluciones ambientales.',
            'area_concurso' => 'Tecnología y Medio Ambiente',
            'fecha_inicio' => Carbon::today()->addDays(10)->toDateString(),
            'fecha_fin' => Carbon::today()->addDays(12)->toDateString(),
            'fecha_limite_inscripcion' => Carbon::today()->addDays(7)->toDateString(),
            'minimo_integrantes' => 3,
            'maximo_integrantes' => 5,
            'cupo_maximo_grupos' => 12,
            'modalidad' => 'HIBRIDA',
            'lugar' => 'Campus UEES / Modalidad virtual',
            'requisitos' => 'Conocimientos básicos en programación, análisis de datos o diseño de soluciones.',
            'estado_concurso' => 'DISPONIBLE',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $concursoInnovacionId = DB::table('concursos')->insertGetId([
            'id_publicacion' => $pubConcurso2,
            'nombre_concurso' => 'Reto de Innovación Social UEES',
            'descripcion_concurso' => 'Competencia para crear propuestas de impacto social mediante tecnología, comunicación, investigación y emprendimiento.',
            'area_concurso' => 'Innovación y Emprendimiento',
            'fecha_inicio' => Carbon::today()->addDays(18)->toDateString(),
            'fecha_fin' => Carbon::today()->addDays(20)->toDateString(),
            'fecha_limite_inscripcion' => Carbon::today()->addDays(14)->toDateString(),
            'minimo_integrantes' => 2,
            'maximo_integrantes' => 4,
            'cupo_maximo_grupos' => 10,
            'modalidad' => 'PRESENCIAL',
            'lugar' => 'Auditorio Principal UEES',
            'requisitos' => 'Presentar una idea inicial y contar con disponibilidad para las jornadas de mentoría.',
            'estado_concurso' => 'DISPONIBLE',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Grupo de concurso de ejemplo
        |--------------------------------------------------------------------------
        */

        $grupoId = DB::table('grupos_concurso')->insertGetId([
            'id_concurso' => $concursoSpaceHackId,
            'id_lider' => $joseId,
            'nombre_grupo' => 'Data Flood Team',
            'descripcion_grupo' => 'Equipo enfocado en análisis de datos, mapas de riesgo y visualización web para el SpaceHack.',
            'cupo_maximo' => 5,
            'estado_grupo' => 'ABIERTO',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Insertamos al líder (José)
        DB::table('miembros_grupo')->insert([
            'id_grupo' => $grupoId,
            'id_usuario' => $joseId,
            'rol_en_grupo' => 'LIDER',
            'fecha_union' => Carbon::today()->toDateString(),
            'estado_miembro' => 'ACTIVO',
        ]);

        // Llenamos el grupo con 4 integrantes adicionales
        $nuevosMiembros = [$anaId, $luisId, $pedroId, $carlosId];
        foreach ($nuevosMiembros as $miembro) {
            DB::table('miembros_grupo')->insert([
                'id_grupo' => $grupoId,
                'id_usuario' => $miembro,
                'rol_en_grupo' => 'INTEGRANTE',
                'fecha_union' => Carbon::today()->toDateString(),
                'estado_miembro' => 'ACTIVO',
            ]);
        }

        // Postulación de Leonor (Sigue pendiente, ahora hacia un grupo lleno)
        DB::table('postulaciones_grupo')->insert([
            'id_grupo' => $grupoId,
            'id_usuario' => $leonorId,
            'mensaje_postulacion' => 'Me interesa participar apoyando en diseño de interfaz y organización del proyecto.',
            'estado_postulacion' => 'PENDIENTE',
            'fecha_postulacion' => Carbon::now(),
            'fecha_respuesta' => null,
            'observacion_respuesta' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Clubes
        |--------------------------------------------------------------------------
        */

        $clubRoboticaId = DB::table('clubes')->insertGetId([
            'id_publicacion' => $pubClub1,
            'id_responsable' => $mariaId, // <-- Responsable actualizada a María
            'nombre_club' => 'Club de Robótica e Inteligencia Artificial',
            'descripcion_club' => 'Club dedicado a la creación de prototipos, robots educativos, automatización e inteligencia artificial aplicada.',
            'cupos_disponibles' => 18,
            'horario' => 'Viernes de 15:00 a 17:00',
            'lugar' => 'Laboratorio de Computación 2',
            'contacto' => 'mgomez@uees.edu.ec',
            'requisitos' => 'Interés en programación, electrónica o innovación tecnológica.',
            'estado_club' => 'DISPONIBLE',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $clubDebateId = DB::table('clubes')->insertGetId([
            'id_publicacion' => $pubClub2,
            'id_responsable' => $carlosId, // <-- Responsable actualizado a Carlos
            'nombre_club' => 'Club de Debate y Liderazgo',
            'descripcion_club' => 'Club orientado a fortalecer habilidades de comunicación, argumentación, liderazgo y participación estudiantil.',
            'cupos_disponibles' => 25,
            'horario' => 'Miércoles de 16:00 a 18:00',
            'lugar' => 'Aula Magna',
            'contacto' => 'cruiz@uees.edu.ec',
            'requisitos' => 'Compromiso de asistencia y disposición para participar en debates académicos.',
            'estado_club' => 'DISPONIBLE',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}