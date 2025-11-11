<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'media_url',
    ];

    protected $appends = [
        'cover_image_url',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class)->orderBy('display_order')->orderBy('id');
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(PortfolioImage::class)->orderBy('display_order')->orderBy('id');
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->relationLoaded('images')
                ? optional($this->images->first())->url
                : optional($this->coverImage()->first())->url,
        );
    }
}
