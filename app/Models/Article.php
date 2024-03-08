<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;
    protected $fillable=['titulo', 'contenido', 'imagen', 'estado', 'category_id', 'user_id'];

    //  Relacion 1:N con user, un articulo pertenece a UN usuario
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    //  Relacion N:M con user un articulo puede tener Like de muchos usuarios
    public function usersLike(): BelongsToMany{
        return $this->belongsToMany(User::class);
    }
    //  Relacion 1:N con categories un articulo tienen una única categoría
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    //Muttators
    public function titulo(): Attribute{
        return Attribute::make(
            set: fn($v)=>ucfirst($v),
        );
    }
    public function contenido(): Attribute{
        return Attribute::make(
            set: fn($v)=>ucfirst($v),
        );
    }
}
