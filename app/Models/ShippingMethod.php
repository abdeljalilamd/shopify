<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingMethod extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'cost'];

    protected $searchableFields = ['*'];

    protected $table = 'shipping_methods';

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
