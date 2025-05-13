<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'user_id',
        'content',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(ForumTopic::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
