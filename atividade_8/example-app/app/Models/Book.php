<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Incluímos 'cover_image' nos campos permitidos para preenchimento
    protected $fillable = [
        'title', 
        'author_id', 
        'category_id', 
        'publisher_id', 
        'published_year',
        'cover_image' // Novo campo para a imagem da capa
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'borrowings')
                    ->withPivot('id', 'borrowed_at', 'returned_at')
                    ->withTimestamps();
    }

    /**
     * Retorna o caminho da imagem de capa ou uma imagem padrão.
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image 
            ? asset('storage/' . $this->cover_image) 
            : asset('images/default_cover.png'); // Caminho da imagem padrão
    }
}
