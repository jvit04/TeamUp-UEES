@extends('layouts.teamup')

@section('title', 'Clubes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-black">Clubes Universitarios</h2>
    
    @if(auth()->user()->id_rol == 1)
        <button class="bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Nuevo Club
        </button>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($clubes as $club)
        <div class="bg-white border border-gray-300 rounded p-5 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-bold text-black">{{ $club->nombre_club }}</h3>
                <span class="bg-gray-200 text-black font-bold px-2 py-1 rounded text-sm">
                    Cupos: {{ $club->cupos_disponibles }}
                </span>
            </div>
            
            <p class="text-sm text-black mb-3"><strong>Horario:</strong> {{ $club->horario }}</p>
            
            <p class="text-black mb-4">
                {{ $club->descripcion_club }}
            </p>

            <a href="{{ route('clubes.show', $club->id_club) }}" class="text-black font-bold hover:underline">
                Ver detalles y unirse
            </a>
        </div>
    @endforeach
</div>
@endsection