@extends('layouts.teamup')

@section('title', 'Concursos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-black">Concursos y Competencias</h2>
    
    @if(auth()->user()->id_rol == 1)
        <button class="bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Nuevo Concurso
        </button>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($concursos as $concurso)
        <div class="bg-white border border-gray-300 rounded p-5 shadow-sm">
            <h3 class="text-lg font-bold text-black">{{ $concurso->nombre_concurso }}</h3>
            <p class="text-sm text-gray-600 mb-3">{{ $concurso->area_concurso }}</p>
            
            <p class="text-black mb-4">
                {{ $concurso->descripcion_concurso }}
            </p>
            
            <div class="text-sm text-black mb-4">
                <strong>Modalidad:</strong> {{ $concurso->modalidad }} <br>
                <strong>Cierre:</strong> {{ \Carbon\Carbon::parse($concurso->fecha_limite_inscripcion)->format('d/m/Y') }}
            </div>

            <a href="{{ route('concursos.show', $concurso->id_concurso) }}" class="text-black font-bold hover:underline">
                Ver detalles y grupos
            </a>
        </div>
    @endforeach
</div>
@endsection