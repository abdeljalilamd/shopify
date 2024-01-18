<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaLink extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['platform', 'url', 'setting_id'];

    protected $searchableFields = ['*'];

    protected $table = 'social_media_links';

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
