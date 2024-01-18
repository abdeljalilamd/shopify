<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'amount', 'coupon_code'];

    protected $searchableFields = ['*'];
}
