<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['image', 'image_url', 'url'];

    protected $searchableFields = ['*'];
}
