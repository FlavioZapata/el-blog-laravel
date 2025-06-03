<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <title>El Blog</title> @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElBlog - @yield('title', 'Inicio')</title>
    <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-gray-800 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold">ElBlog</a>
            <div>
                <a href="{{ route('categorias.index') }}" class="px-3 py-2 rounded hover:bg-gray-700">Categorías</a>
                <a href="{{ route('posts.index') }}" class="px-3 py-2 rounded hover:bg-gray-700">Posts</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Oops!</strong>
                <span class="block sm:inline">Hubo algunos problemas con tu entrada.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>