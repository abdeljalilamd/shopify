<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['product_id', 'customer_id', 'rating', 'text'];

    protected $searchableFields = ['*'];

    protected $table = 'product_reviews';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
