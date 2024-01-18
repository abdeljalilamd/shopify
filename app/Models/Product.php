<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'categorie_id',
        'title',
        'slug',
        'image',
        'description',
        'price',
        'content',
    ];

    protected $searchableFields = ['*'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function customerWishlists()
    {
        return $this->hasMany(CustomerWishlist::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function productTags()
    {
        return $this->hasMany(ProductTag::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
