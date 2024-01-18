<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoMeta extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['seo_setting_id', 'type', 'key'];

    protected $searchableFields = ['*'];

    protected $table = 'seo_metas';

    public function seoSetting()
    {
        return $this->belongsTo(SeoSetting::class);
    }
}
