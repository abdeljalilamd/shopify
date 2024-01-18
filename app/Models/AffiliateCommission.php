<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffiliateCommission extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['affiliate_program_id', 'amount'];

    protected $searchableFields = ['*'];

    protected $table = 'affiliate_commissions';

    public function affiliateProgram()
    {
        return $this->belongsTo(AffiliateProgram::class);
    }
}
