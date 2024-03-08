<?php

namespace App\Livewire;

use App\Livewire\Forms\ArticuloUpdate;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UserArticles extends Component
{
    use WithPagination;
    use WithFileUploads;

    public ArticuloUpdate $form;
    public bool $openModalEditar = false;

    public bool $openModalLikes = false;

    public string $search = "", $campo = "id_art", $orden = "desc";


    #[On('articulo-creado')]
    public function render()
    {
        $articulos = Article::select('articles.id as id_art', 'imagen', 'nombre', 'estado', 'user_id', 'titulo', 'color')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->where('user_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('titulo', 'like', "%$this->search%")
                    ->orWhere('estado', 'like', "%$this->search%")
                    ->orWhere('nombre', 'like', "%$this->search%");
            })
            ->orderBy($this->campo, $this->orden)
            ->paginate(5);

        $categorias = Category::select('id', 'nombre')->orderBy('nombre')->get();

        $misLikes = Article::whereHas('usersLike', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })
            ->orderBy('titulo')
            ->get();

        return view('livewire.user-articles', compact('articulos', 'categorias', 'misLikes'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function cambiarEstado(Article $articulo)
    {
        $this->authorize('update', $articulo);
        $estado = ($articulo->estado == 'PUBLICADO') ? 'BORRADOR' : 'PUBLICADO';
        $articulo->update([
            'estado' => $estado,
        ]);
    }

    //Borrar ------------------------------------
    public function pedirPermisoBorrar(String $id)
    {
        $this->authorize('delete', Article::find($id));
        $this->dispatch('confirmarBorrar', $id);
    }

    #[On('borrarConfirmado')]
    public function delete(Article $articulo)
    {
        $this->authorize('delete', $articulo);
        if (basename($articulo->imagen) != 'noimage.png') {
            Storage::delete($articulo->imagen);
        }
        $articulo->delete();
        $this->dispatch('mensaje', '¡¡Artículo eliminado!!');
    }

    //Editar --------------------------------------------------------------------------
    public function editar(Article $articulo)
    {
        $this->authorize('update', $articulo);
        $this->form->setArticulo($articulo);
        $this->openModalEditar = true;
    }
    public function update()
    {
        $this->authorize('update', $this->form->articulo);
        $this->form->updateForm();
        $this->limpiarUpdate();
        $this->dispatch('mensaje', '¡¡ Articulo actualizado !!');
    }
    public function limpiarUpdate()
    {
        $this->form->limpiarUpdate();
        $this->reset(['openModalEditar']);
    }
}
