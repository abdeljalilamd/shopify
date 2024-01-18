<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExternalIntegration extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'api_key', 'token'];

    protected $searchableFields = ['*'];

    protected $table = 'external_integrations';
}
