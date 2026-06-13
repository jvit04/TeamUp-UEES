@extends('layouts.teamup')

@section('title', 'Mis Grupos')

@section('content')
<h2 class="text-2xl font-bold text-black mb-6">Panel de Gestión: Mis Grupos</h2>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 font-bold">
        {{ session('success') }}
    </div>
@endif

@if($grupos->isEmpty())
    <div class="bg-white border border-gray-300 rounded p-8 text-center shadow-sm">
        <p class="text-black text-lg">Actualmente no eres líder de ningún grupo.</p>
        <p class="text-gray-500 mt-2">¡Ve a la sección de concursos y anímate a fundar tu propio equipo!</p>
    </div>
@else
    <div class="space-y-8">
        @foreach($grupos as $grupo)
            <div class="bg-white border border-gray-300 rounded shadow-sm overflow-hidden">
                <div class="bg-gray-100 p-4 border-b border-gray-300 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-black">{{ $grupo->nombre_grupo }}</h3>
                        <p class="text-sm text-gray-700 font-semibold mt-1">Competencia: {{ $grupo->concurso->nombre_concurso ?? 'N/A' }}</p>
                    </div>
                    <span class="bg-black text-white font-bold px-3 py-1 rounded text-sm">
                        Cupo Total: {{ $grupo->cupo_maximo }}
                    </span>
                </div>

                <div class="p-5">
                    <h4 class="font-bold text-black mb-4">Postulaciones Pendientes</h4>
                    
                    @php
                        // Filtramos solo las solicitudes que están en estado PENDIENTE
                        $pendientes = $grupo->postulaciones->where('estado_postulacion', 'PENDIENTE');
                    @endphp

                    @if($pendientes->isEmpty())
                        <div class="bg-gray-50 border border-dashed border-gray-300 rounded p-4 text-center">
                            <p class="text-gray-600 text-sm">No tienes solicitudes nuevas en este momento.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($pendientes as $postulacion)
                                <div class="border border-gray-300 rounded p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:bg-gray-50 transition">
                                    <div>
                                        <p class="font-bold text-black text-lg">
                                            {{ $postulacion->usuario->nombres ?? 'Estudiante' }} {{ $postulacion->usuario->apellidos ?? '' }}
                                        </p>
                                        <p class="text-sm text-gray-800 italic mt-1">"{{ $postulacion->mensaje_postulacion }}"</p>
                                        <p class="text-xs text-gray-500 mt-2 font-semibold uppercase">
                                            Carrera: {{ $postulacion->usuario->carrera ?? 'N/A' }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex gap-3">
                                        <form action="{{ route('postulaciones.responder', $postulacion->id_postulacion_grupo) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="accion" value="ACEPTAR">
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                                                Aceptar
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('postulaciones.responder', $postulacion->id_postulacion_grupo) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="accion" value="RECHAZAR">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection