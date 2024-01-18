<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffiliateProgram extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['affiliate_id', 'referral_id', 'commission'];

    protected $searchableFields = ['*'];

    protected $table = 'affiliate_programs';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'affiliate_id');
    }

    public function referral()
    {
        return $this->belongsTo(Customer::class, 'referral_id');
    }

    public function affiliateCommissions()
    {
        return $this->hasMany(AffiliateCommission::class);
    }
}
