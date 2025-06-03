@extends('layouts.app')

@section('title', 'Listado de Posts')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold text-gray-800">Posts</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Post
        </a>
    </div>

    @if ($posts->isEmpty())
    <p class="text-gray-600">No hay posts registrados.</p>
    @else
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Título</th>
                <th class="py-2 px-4 border-b">Categoría</th>
                <th class="py-2 px-4 border-b">Imagen</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $post->id }}</td>
                <td class="py-2 px-4 border-b">{{ $post->titulo }}</td>
                <td class="py-2 px-4 border-b">{{ $post->categoria->nombre }}</td>
                <td class="py-2 px-4 border-b text-center">
                    @if($post->imagen)
                    <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen del Post" class="w-16 h-16 object-cover mx-auto rounded">
                    @else
                    No image
                    @endif
                </td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                    <a href="{{ route('posts.edit', $post->id) }}" class="text-yellow-600 hover:text-yellow-900 ml-2">Editar</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('¿Estás seguro de que quieres eliminar este post?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if($posts->isEmpty())
            <tr>
                <td colspan="5" class="py-4 px-4 text-center text-gray-500">No hay posts registrados.</td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif
</div>
@endsection