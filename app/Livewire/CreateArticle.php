<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticle extends Component
{
    use WithFileUploads;

    public bool $openModalCrear=false;

    #[Validate(['nullable', 'image', 'max:2028'])]
    public $imagen;

    #[Validate(['required', 'string', 'min:3', 'unique:articles,titulo'])]
    public string $titulo="";

    #[Validate(['required', 'string', 'min:10'])]
    public string $contenido="";

    #[Validate(['nullable'])]
    public ?string $estado=null;

    #[Validate(['required', 'exists:categories,id'])]
    public string $category_id="";


    public function render()
    {
        $categorias=Category::select("id", "nombre")->orderBy('nombre')->get();
        return view('livewire.create-article', compact('categorias'));
    }

    public function store(){
        $this->validate();
        Article::create([
            'titulo'=>$this->titulo,
            'contenido'=>$this->contenido,
            'imagen'=>($this->imagen) ? $this->imagen->store('productos') : 'noimage.png',
            'user_id'=>auth()->user()->id,
            'category_id'=>$this->category_id,
            'estado'=>$this->estado ? "PUBLICADO" : "BORRADOR",
        ]);
        $this->limpiarCrear();
        $this->dispatch('mensaje', 'Artículo guardado');
        $this->dispatch('articulo-creado')->to(UserArticles::class);
    }
    public function limpiarCrear(){
        $this->reset(['titulo', 'imagen', 'category_id', 'estado', 'openModalCrear', 'contenido']);
    }
}
