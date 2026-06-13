@extends('layouts.teamup')

@section('title', $club->nombre_club)

@section('content')
<div class="mb-4">
    <a href="{{ route('clubes.index') }}" class="text-black font-bold hover:underline">
        Volver a clubes
    </a>
</div>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-black">{{ $club->nombre_club }}</h2>
    <span class="bg-gray-200 text-black font-bold px-3 py-1 rounded border border-gray-300">
        Cupos: {{ $club->cupos_disponibles }}
    </span>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="md:col-span-2 bg-white border border-gray-300 rounded p-5 shadow-sm">
        <h3 class="text-lg font-bold text-black mb-2">Acerca del Club</h3>
        <p class="text-black mb-6">{{ $club->descripcion_club }}</p>

        <h3 class="text-lg font-bold text-black mb-2">Detalles Adicionales</h3>
        <ul class="text-black space-y-2 mb-4">
            <li><strong>Horario:</strong> {{ $club->horario }}</li>
            <li><strong>Lugar:</strong> {{ $club->lugar }}</li>
            <li><strong>Requisitos:</strong> {{ $club->requisitos }}</li>
            <li><strong>Contacto:</strong> {{ $club->contacto }}</li>
            <li><strong>Responsable:</strong> {{ $club->responsable->nombres ?? 'Administrador' }} {{ $club->responsable->apellidos ?? '' }}</li>
        </ul>
    </div>

    <div class="md:col-span-1 bg-white border border-gray-300 rounded p-5 shadow-sm h-fit">
        @if(auth()->user()->id_rol == 1)
            <h3 class="text-lg font-bold text-black mb-2">Administración</h3>
            <p class="text-sm text-black mb-4">Como administrador, puedes modificar los detalles de este club o gestionar sus integrantes.</p>
            <button class="w-full bg-gray-200 text-black font-bold py-2 px-4 rounded border border-gray-400">
                Editar Club
            </button>
        @else
            <h3 class="text-lg font-bold text-black mb-2">Únete al Club</h3>
            <p class="text-sm text-black mb-4">Llena el formulario para enviar tu solicitud de ingreso. El responsable la revisará pronto.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('clubes.postular', $club->id_club) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-black font-bold mb-1 text-sm">Motivo de postulación:</label>
                    <textarea name="motivo_postulacion" rows="2" class="w-full border border-gray-300 rounded p-2 text-black text-sm" required></textarea>
                </div>
                <div>
                    <label class="block text-black font-bold mb-1 text-sm">Experiencia previa (opcional):</label>
                    <textarea name="experiencia_previa" rows="2" class="w-full border border-gray-300 rounded p-2 text-black text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-black font-bold mb-1 text-sm">Disponibilidad horaria:</label>
                    <input type="text" name="disponibilidad_horaria" class="w-full border border-gray-300 rounded p-2 text-black text-sm" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Enviar Postulación
                </button>
            </form>
        @endif
    </div>

</div>
@endsection