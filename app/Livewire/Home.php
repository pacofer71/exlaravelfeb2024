<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{

    use WithPagination;
    public ?User $usuario = null;
    public string $search="";

    public function render()
    {
        $this->usuario = auth()->user() ?? null;
        
        $articulos = Article::with('category')
        ->where('estado', 'PUBLICADO')
        ->where('titulo', 'like', "%{$this->search}%")->orderBy('id', 'desc')->paginate(5);
        
        $articulosLikes = ($this->usuario != null) ? $this->usuario->getArticlesLikesId() : [];
        
        return view('welcome', compact('articulos', 'articulosLikes'));
    }

    public function like(Article $articulo)
    {
        $articulosLikes = $this->usuario->getArticlesLikesId() ?? [];
        if(($key=array_search($articulo->id, $articulosLikes))!=false){
            unset($articulosLikes[$key]);
        }else{
            $articulosLikes[]=$articulo->id;
        }
        $this->usuario->articlesLike()->sync($articulosLikes);
    }
}
