<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Sticker extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['sticker_type', 'sticker'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('sticker');
    }
}
