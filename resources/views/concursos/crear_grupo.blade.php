@extends('layouts.teamup')

@section('title', 'Crear Grupo')

@section('content')
<div class="mb-4">
    <a href="{{ route('concursos.show', $concurso->id_concurso) }}" class="text-black font-bold hover:underline">
        &larr; Volver al concurso
    </a>
</div>

<h2 class="text-2xl font-bold text-black mb-6">Crear Grupo para: {{ $concurso->nombre_concurso }}</h2>

<div class="bg-white border border-gray-300 rounded p-6 shadow-sm max-w-2xl">
    <form action="{{ route('grupos.guardar', $concurso->id_concurso) }}" method="POST" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-black font-bold mb-1">Nombre del Grupo</label>
            <input type="text" name="nombre_grupo" class="w-full border border-gray-300 rounded p-2 text-black" required>
        </div>

        <div>
            <label class="block text-black font-bold mb-1">Descripción / ¿Qué perfiles buscas?</label>
            <textarea name="descripcion_grupo" rows="3" placeholder="Ej: Buscamos un integrante adicional que sepa programar en Laravel..." class="w-full border border-gray-300 rounded p-2 text-black" required></textarea>
        </div>

        <div>
            <label class="block text-black font-bold mb-1">Cupo Máximo (Total de integrantes)</label>
            <input type="number" name="cupo_maximo" min="{{ $concurso->minimo_integrantes }}" max="{{ $concurso->maximo_integrantes }}" value="{{ $concurso->minimo_integrantes }}" class="w-full border border-gray-300 rounded p-2 text-black" required>
            <p class="text-xs text-gray-500 mt-1">Este concurso permite entre {{ $concurso->minimo_integrantes }} y {{ $concurso->maximo_integrantes }} personas.</p>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded mt-4 transition">
            Guardar y Publicar Grupo
        </button>
    </form>
</div>
@endsection