<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ForumCategory;
use App\Models\ForumMessage;
use App\Models\ForumTopic;
use App\Models\ForumTopicUserRead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class CreateTopicForm extends Component
{
    public string $title = '';
    public string $content = '';
    public ?int $categoryId = null;
    public $categories = []; // Remove typehint to allow collection or array

    protected function rules(): array
    {
        return [
            'categoryId' => 'required|exists:forum_categories,id',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
        ];
    }

    protected array $messages = [
        'categoryId.required' => 'Kategori seçimi zorunludur.',
        'title.required' => 'Başlık alanı zorunludur.',
        'title.min' => 'Başlık en az 3 karakter olmalıdır.',
        'content.required' => 'Mesaj içeriği zorunludur.',
        'content.min' => 'Mesaj içeriği en az 10 karakter olmalıdır.',
    ];

    public function mount($categories = null): void
    {
        // Check if forum_categories table exists first
        if (!Schema::hasTable('forum_categories')) {
            $this->categories = collect([]);
            return;
        }
        
        // Ensure categories is a collection of models, not an array
        if ($categories) {
            $this->categories = is_array($categories) ? collect($categories) : $categories;
        } else {
            $this->categories = ForumCategory::orderBy('name')->get();
        }

        if ($this->categories->count() > 0 && $this->categoryId === null) {
            $this->categoryId = $this->categories->first()->id; // Default to first category
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        if (!($user->hasRole('dentist') || $user->hasRole('admin')) || $user->fresh()->is_banned_from_forum) {
            session()->flash('error', __('Yeni başlık oluşturma yetkiniz yok veya forumdan yasaklandınız.'));
            $this->dispatch('notify', ['message' => __('Yeni başlık oluşturma yetkiniz yok veya forumdan yasaklandınız.'), 'type' => 'error']);
            return;
        }

        $topic = ForumTopic::create([
            'category_id' => $this->categoryId,
            'user_id' => $user->id,
            'title' => $this->title,
            // Slug is handled by model event
        ]);

        ForumMessage::create([
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'content' => $this->content,
        ]);
        
        // Mark this new topic as read for the creator
        if (Auth::check()) {
            ForumTopicUserRead::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'topic_id' => $topic->id,
                ],
                ['last_read_at' => now()]
            );
        }

        $this->reset('title', 'content');
        // Could also default categoryId again if needed

        $this->dispatch('topicCreated', $topic->id);
        $this->dispatch('closeModal'); // To close the parent modal
        session()->flash('message', __('Başlık başarıyla oluşturuldu!'));
    }

    public function render(): View
    {
        // Return view without forum categories if table doesn't exist
        if (!Schema::hasTable('forum_categories')) {
            session()->flash('error', __('Forum henüz kurulmamış. Lütfen daha sonra tekrar deneyin.'));
            return view('livewire.create-topic-form');
        }
        
        return view('livewire.create-topic-form');
    }
}
