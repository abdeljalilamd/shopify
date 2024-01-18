<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'image', 'description', 'slug'];

    protected $searchableFields = ['*'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
