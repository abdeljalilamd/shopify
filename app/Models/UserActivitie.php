<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivitie extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'name', 'description', 'type'];

    protected $searchableFields = ['*'];

    protected $table = 'user_activities';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
