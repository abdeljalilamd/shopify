<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refund extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['returnProdct_id', 'amount'];

    protected $searchableFields = ['*'];

    public function returnProdct()
    {
        return $this->belongsTo(ReturnProdct::class, 'returnProdct_id');
    }
}
