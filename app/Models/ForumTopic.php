<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'is_pinned',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ForumMessage::class, 'topic_id');
    }

    // Helper to get the last message for sorting/display
    public function lastMessage(): HasOne
    {
        return $this->hasOne(ForumMessage::class, 'topic_id')->latestOfMany();
    }

    public function userReads(): HasMany
    {
        return $this->hasMany(ForumTopicUserRead::class, 'topic_id');
    }

    public function isUnreadForUser(?User $user): bool
    {
        if (!$user) return false;
        $lastReadTimestamp = $user->lastReadAt($this->id);
        if (!$lastReadTimestamp) return true; // Never read is unread

        $lastMessage = $this->lastMessage;
        if (!$lastMessage) return false; // No messages, so not unread

        return $lastMessage->created_at->gt($lastReadTimestamp);
    }

    protected static function booted(): void
    {
        static::creating(function (ForumTopic $topic) {
            // Diagnostic: Dump attributes during creation to trace forum_category_id
            // Ensure to remove this after debugging
            // info('ForumTopic creating attributes:', $topic->getAttributes()); 
            // dd($topic->getAttributes()); // This will halt execution

            if (empty($topic->slug)) {
                $topic->slug = \Illuminate\Support\Str::slug($topic->title);
            }
        });

        static::updating(function (ForumTopic $topic) {
            if ($topic->isDirty('title') && empty($topic->slug)) {
                $topic->slug = \Illuminate\Support\Str::slug($topic->title);
            }
        });
    }
}
