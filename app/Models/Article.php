<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'brand_id',
    ];

    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class);
    }

    public function variants(): HasMany {
        return $this->hasMany(Variant::class);
    }
}
