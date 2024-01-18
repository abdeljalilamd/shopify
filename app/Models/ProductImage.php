<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['product_id', 'image_url', 'image'];

    protected $searchableFields = ['*'];

    protected $table = 'product_images';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
