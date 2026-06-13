@extends('layouts.teamup')

@section('title', $concurso->nombre_concurso)

@section('content')
<div class="mb-4">
    <a href="{{ route('concursos.index') }}" class="text-black font-bold hover:underline">
        &larr; Volver a concursos
    </a>
</div>

<h2 class="text-2xl font-bold text-black mb-6">{{ $concurso->nombre_concurso }}</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="md:col-span-1 bg-white border border-gray-300 rounded p-5 shadow-sm h-fit">
        <h3 class="text-lg font-bold text-black mb-2">Detalles</h3>
        <p class="text-black mb-4">{{ $concurso->descripcion_concurso }}</p>
        
        <ul class="text-black space-y-2 mb-4">
            <li><strong>Área:</strong> {{ $concurso->area_concurso }}</li>
            <li><strong>Lugar:</strong> {{ $concurso->lugar }}</li>
            <li><strong>Integrantes:</strong> {{ $concurso->minimo_integrantes }} a {{ $concurso->maximo_integrantes }}</li>
        </ul>
    </div>

    <div class="md:col-span-2 bg-white border border-gray-300 rounded p-5 shadow-sm">
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 font-bold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-black">Grupos buscando miembros</h3>
            
            @if(!$usuarioTieneGrupo)
                <a href="{{ route('grupos.crear', $concurso->id_concurso) }}" class="text-black font-bold hover:underline">
                    + Crear mi grupo
                </a>
            @else
                <span class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-sm border border-gray-300 shadow-sm">
                    Ya tienes un equipo
                </span>
            @endif
        </div>

        @if($grupos->isEmpty())
            <div class="bg-gray-50 border border-dashed border-gray-300 rounded p-6 text-center">
                <p class="text-gray-600">No hay grupos creados para este concurso.</p>
            </div>
        @else
            @foreach($grupos as $grupo)
                <div class="border border-gray-300 rounded p-4 mb-4 flex justify-between items-center hover:bg-gray-50 transition">
                    <div>
                        <h4 class="font-bold text-black">{{ $grupo->nombre_grupo }}</h4>
                        <p class="text-black">{{ $grupo->descripcion_grupo }}</p>
                        <p class="text-sm text-gray-600 mt-1">Líder: {{ $grupo->lider->nombres ?? 'Estudiante' }}</p>
                    </div>
                    
                    @php
                        $yaPostulo = $grupo->postulaciones->where('id_usuario', auth()->user()->id_usuario)->isNotEmpty();
                    @endphp

                    @if(auth()->user()->id_usuario == $grupo->id_lider)
                        <span class="bg-gray-200 text-gray-700 font-bold py-1 px-3 rounded text-sm border border-gray-300">
                            Eres el líder
                        </span>
                    @elseif($usuarioTieneGrupo)
                        @elseif($yaPostulo)
                        <span class="bg-yellow-100 text-yellow-800 font-bold py-1 px-3 rounded text-sm border border-yellow-300">
                            Solicitud Enviada
                        </span>
                    @else
                        <form action="{{ route('grupos.postular', $grupo->id_grupo) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                Postularme
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

</div>
@endsection