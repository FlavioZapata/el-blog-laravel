@extends('layouts.app')

@section('title', 'Listado de Categorías')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">Categorías</h1>
            <a href="{{ route('categorias.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Categoría
            </a>
        </div>

        @if ($categorias->isEmpty())
            <p class="text-gray-600">No hay categorías registradas.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-gray-700">ID</th>
                        <th class="py-2 px-4 border-b text-left text-gray-700">Nombre</th>
                        <th class="py-2 px-4 border-b text-left text-gray-700">Descripción</th>
                        <th class="py-2 px-4 border-b text-left text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td class="py-2 px-4 border-b text-gray-800">{{ $categoria->id }}</td>
                            <td class="py-2 px-4 border-b text-gray-800">{{ $categoria->nombre }}</td>
                            <td class="py-2 px-4 border-b text-gray-800">{{ $categoria->descripcion }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('categorias.show', $categoria->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                                <a href="{{ route('categorias.edit', $categoria->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Editar</a>
                                <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection