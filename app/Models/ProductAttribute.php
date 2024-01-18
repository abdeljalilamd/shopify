<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['product_id', 'name', 'value'];

    protected $searchableFields = ['*'];

    protected $table = 'product_attributes';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
