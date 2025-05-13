<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ForumCategory;
use App\Models\ForumTopic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class EditTopicForm extends Component
{
    public ?ForumTopic $topic = null;
    public int $topicId;
    public string $title = '';
    public ?int $categoryId = null;
    public array $categories = [];

    protected function rules(): array
    {
        return [
            'categoryId' => 'required|exists:forum_categories,id',
            'title' => 'required|string|min:3|max:255',
        ];
    }

    protected array $messages = [
        'categoryId.required' => 'Kategori seçimi zorunludur.',
        'title.required' => 'Başlık alanı zorunludur.',
        'title.min' => 'Başlık en az 3 karakter olmalıdır.',
    ];

    public function mount(int $topicId, array $categories = []): void
    {
        $this->topicId = $topicId;
        $this->topic = ForumTopic::find($this->topicId);
        $this->categories = $categories ?: ForumCategory::orderBy('name')->get()->toArray();

        if (!$this->topic || !Auth::user()->can('update', $this->topic)) {
            session()->flash('error', __('Başlık bulunamadı veya düzenleme yetkiniz yok.'));
            $this->dispatch('closeModal');
            return;
        }

        $this->title = $this->topic->title;
        $this->categoryId = $this->topic->category_id;
    }

    public function updateTopic(): void
    {
        if (!$this->topic || !Auth::user()->can('update', $this->topic)) {
            session()->flash('error', __('Başlık güncellenemedi.'));
            $this->dispatch('closeModal');
            return;
        }

        $this->validate();

        $this->topic->title = $this->title;
        $this->topic->category_id = $this->categoryId;
        // Slug will be updated by model event if title changes
        if ($this->topic->isDirty('title')) {
            $this->topic->slug = Str::slug($this->title); 
        }
        $this->topic->save();

        session()->flash('message', __('Başlık başarıyla güncellendi.'));
        $this->dispatch('topicUpdated', $this->topic->id);
        $this->dispatch('closeModal');
    }

    public function render(): View
    {
        return view('livewire.edit-topic-form');
    }
}
