<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ForumMessage;
use App\Models\ForumTopicUserRead;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class PostMessageForm extends Component
{
    public int $topicId;
    public string $content = '';

    protected function rules(): array
    {
        return [
            'content' => 'required|string|min:1',
        ];
    }

    protected array $messages = [
        'content.required' => 'Mesaj içeriği boş olamaz.',
        'content.min' => 'Mesaj içeriği en az 1 karakter olmalıdır.',
    ];

    public function mount(int $topicId): void
    {
        $this->topicId = $topicId;
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        if (!($user->hasRole('dentist') || $user->hasRole('admin')) || $user->fresh()->is_banned_from_forum) {
            session()->flash('error', __('Mesaj gönderme yetkiniz yok veya forumdan yasaklandınız.'));
            $this->dispatch('notify', ['message' => __('Mesaj gönderme yetkiniz yok veya forumdan yasaklandınız.'), 'type' => 'error']);
            return;
        }

        ForumMessage::create([
            'topic_id' => $this->topicId,
            'user_id' => $user->id,
            'content' => $this->content,
        ]);

        // Mark this topic as read for the user since they posted
        if ($user) {
            ForumTopicUserRead::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'topic_id' => $this->topicId,
                ],
                ['last_read_at' => now()]
            );
        }

        $this->reset('content');
        $this->dispatch('messagePosted', $this->topicId);
        $this->dispatch('notify', ['message' => __('Mesaj başarıyla gönderildi!'), 'type' => 'success']);
    }

    public function render(): View
    {
        return view('livewire.post-message-form');
    }
}
