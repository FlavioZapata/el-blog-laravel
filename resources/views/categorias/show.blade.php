@extends('layouts.app')

@section('title', 'Detalle de Categoría')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Detalles de la Categoría</h1>

        <div class="mb-4">
            <p class="text-gray-700"><strong class="font-semibold">ID:</strong> {{ $categoria->id }}</p>
            <p class="text-gray-700"><strong class="font-semibold">Nombre:</strong> {{ $categoria->nombre }}</p>
            <p class="text-gray-700"><strong class="font-semibold">Descripción:</strong> {{ $categoria->descripcion ?? 'N/A' }}</p>
            <p class="text-gray-700"><strong class="font-semibold">Creado:</strong> {{ $categoria->created_at->format('d/m/Y H:i') }}</p>
            <p class="text-gray-700"><strong class="font-semibold">Actualizado:</strong> {{ $categoria->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="flex items-center justify-start">
            <a href="{{ route('categorias.edit', $categoria->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                Editar
            </a>
            <a href="{{ route('categorias.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Volver al Listado
            </a>
        </div>
    </div>
@endsection