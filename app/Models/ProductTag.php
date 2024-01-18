<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTag extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['tag', 'product_id'];

    protected $searchableFields = ['*'];

    protected $table = 'product_tags';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
