<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticuloUpdate extends Form
{
    public ?Article $articulo=null;
    public string $titulo="";
    public string $contenido="";
    public $imagen;
    public string $category_id="";
    public ?string $estado=null;
    
    public function setArticulo(Article $articulo){
        $this->articulo=$articulo;
        $this->titulo=$articulo->titulo;
        $this->contenido=$articulo->contenido;
        $this->category_id=$articulo->category_id;
        $this->estado=$articulo->estado;
    }

    public function rules(): array{
        return [
            'imagen'=>['nullable', 'image', 'max:2028'],
            'titulo'=>['required', 'string', 'min:3', 'unique:articles,titulo,'.$this->articulo->id],
            'contenido'=>[['required', 'string', 'min:10']],
            'category_id'=>['required', 'exists:categories,id'],
            'estado'=>['nullable'],
        ];
    }

    public function updateForm(){
        $this->validate();
        $ruta=$this->articulo->imagen;
        if($this->imagen){
            if(basename($this->articulo->imagen)!='noimage.png'){
                Storage::delete($this->articulo->imagen);
                $ruta=$this->imagen->store('productos');
            }
        }
        $this->articulo->update([
            'titulo'=>$this->titulo,
            'contenido'=>$this->contenido,
            'imagen'=>$ruta,
            'user_id'=>auth()->user()->id,
            'category_id'=>$this->category_id,
            'estado'=>$this->estado ? "PUBLICADO" : "BORRADOR",
        ]);
        
    }
    public function limpiarUpdate(){
        $this->reset(['articulo', 'titulo', 'contenido', 'imagen', 'estado', 'category_id']);
    }
}
