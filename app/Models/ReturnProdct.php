<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnProdct extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['order_id', 'reason'];

    protected $searchableFields = ['*'];

    protected $table = 'return_prodcts';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class, 'returnProdct_id');
    }
}
