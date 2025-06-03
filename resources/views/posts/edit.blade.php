@extends('layouts.app')

@section('title', 'Editar Post')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Editar Post</h1>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                <input type="text" name="titulo" id="titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('titulo', $post->titulo) }}" required>
            </div>
            <div class="mb-4">
                <label for="contenido" class="block text-gray-700 text-sm font-bold mb-2">Contenido:</label>
                <textarea name="contenido" id="contenido" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('contenido', $post->contenido) }}</textarea>
            </div>
            <div class="mb-4">
                <label for="categoria_id" class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                <select name="categoria_id" id="categoria_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $post->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="imagen" class="block text-gray-700 text-sm font-bold mb-2">Imagen Actual:</label>
                @if ($post->imagen)
                    <img src="{{ asset('storage/' . $post->imagen) }}" alt="{{ $post->titulo }}" class="w-32 h-32 object-cover rounded mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="delete_imagen" value="1" class="form-checkbox h-5 w-5 text-red-600">
                        <span class="ml-2 text-gray-700">Eliminar imagen actual</span>
                    </label>
                @else
                    <p class="text-gray-600 mb-2">No hay imagen actual.</p>
                @endif

                <label for="imagen" class="block text-gray-700 text-sm font-bold mb-2 mt-4">Subir Nueva Imagen:</label>
                <input type="file" name="imagen" id="imagen" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Actualizar Post
                </button>
                <a href="{{ route('posts.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection