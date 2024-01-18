<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['user_id', 'address', 'city'];

    protected $searchableFields = ['*'];

    public function customerWishlists()
    {
        return $this->hasMany(CustomerWishlist::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function affiliatePrograms()
    {
        return $this->hasMany(AffiliateProgram::class, 'affiliate_id');
    }

    public function referralPrograms()
    {
        return $this->hasMany(AffiliateProgram::class, 'referral_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
