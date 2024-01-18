<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerWishlist extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['customer_id', 'product_id'];

    protected $searchableFields = ['*'];

    protected $table = 'customer_wishlists';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
