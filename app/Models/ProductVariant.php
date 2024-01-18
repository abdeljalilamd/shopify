<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['product_id', 'name', 'price'];

    protected $searchableFields = ['*'];

    protected $table = 'product_variants';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
