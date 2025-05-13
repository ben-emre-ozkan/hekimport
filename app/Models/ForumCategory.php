<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(ForumTopic::class, 'category_id');
    }

    protected static function booted(): void
    {
        static::creating(function (ForumCategory $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function (ForumCategory $category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
