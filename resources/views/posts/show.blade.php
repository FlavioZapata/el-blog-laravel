@extends('layouts.app')

@section('title', 'Detalle de Post')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $post->titulo }}</h1>

        <div class="mb-4">
            <p class="text-gray-700"><strong class="font-semibold">Categoría:</strong> {{ $post->categoria->nombre }}</p>
            @if ($post->imagen)
                <div class="mt-4">
                    <img src="{{ asset('storage/' . $post->imagen) }}" alt="{{ $post->titulo }}" class="max-w-full h-auto rounded-lg shadow-md">
                </div>
            @endif
            <p class="text-gray-700 mt-4 leading-relaxed">{{ $post->contenido }}</p>
            <p class="text-gray-600 text-sm mt-4">
                <strong class="font-semibold">Creado:</strong> {{ $post->created_at->format('d/m/Y H:i') }} |
                <strong class="font-semibold">Actualizado:</strong> {{ $post->updated_at->format('d/m/Y H:i') }}
            </p>
        </div>

        <div class="flex items-center justify-start mt-6">
            <a href="{{ route('posts.edit', $post->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                Editar
            </a>
            <a href="{{ route('posts.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Volver al Listado
            </a>
        </div>
    </div>
@endsection