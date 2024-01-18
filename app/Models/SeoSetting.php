<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoSetting extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['meta_description', 'image'];

    protected $searchableFields = ['*'];

    protected $table = 'seo_settings';

    public function seoMetas()
    {
        return $this->hasMany(SeoMeta::class);
    }
}
