<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categoria; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('categoria')->get(); 
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); 
        return view('posts.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            
            $imagePath = $request->file('imagen')->store('posts', 'public');
            $validatedData['imagen'] = $imagePath; 
        } else {
            $validatedData['imagen'] = null; 
        }

        $post = Post::create($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post creado exitosamente.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categorias = Categoria::all();
        return view('posts.edit', compact('post', 'categorias'));
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($post->imagen) {
                Storage::disk('public')->delete($post->imagen); 
            }

            $imagePath = $request->file('imagen')->store('posts', 'public');
            $validatedData['imagen'] = $imagePath;
        } elseif ($request->has('delete_imagen') && $post->imagen) {
            
            Storage::disk('public')->delete($post->imagen);
            $validatedData['imagen'] = null;
        } else {
            
            $validatedData['imagen'] = $post->imagen;
        }

        $post->update($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post actualizado exitosamente.');
    }

    public function destroy(Post $post)
    {
        if ($post->imagen && Storage::disk('public')->exists($post->imagen)) {
            Storage::disk('public')->delete($post->imagen);
        }

        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Post eliminado exitosamente.');
    }
}