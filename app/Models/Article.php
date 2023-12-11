<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use Translatable, HasFactory, CreatedAtTrait, UpdatedAtTrait, SoftDeletes, InteractsWithMedia;

    public $translatedAttributes = ['title', 'text'];
    protected $hidden = ['translations'];
    protected $table = 'articles';
    protected $fillable = ['editor_id'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function editor()
    {
        return $this->belongsTo(Editor::class);
    }

    public function getImageAttribute()
    {
        if ($this->getFirstMediaUrl('Article')) {
            return $this->getFirstMediaUrl('Article');
        } else {
            return url('images/logo.jpg');
        }
    }
}
