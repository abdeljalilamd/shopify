<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'subject', 'content'];

    protected $searchableFields = ['*'];

    protected $table = 'email_templates';
}
