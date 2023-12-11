<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable,
    CreatedAtTrait, UpdatedAtTrait, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'birthday',
        'gender',
    ];

    protected $hidden = ['password'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function getImageAttribute()
    {
        if ($this->getFirstMediaUrl('User')) {
            return $this->getFirstMediaUrl('User');
        } else {
            return url('images/logo.jpg');
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
