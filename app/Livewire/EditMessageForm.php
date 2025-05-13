<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ForumMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class EditMessageForm extends Component
{
    public ?ForumMessage $message = null;
    public int $messageId;
    public string $content = '';

    // Passed to satisfy the modal in ForumDisplay which expects categories
    // Not actually used by this form directly for its own logic.
    public array $categories = []; 

    protected function rules(): array
    {
        return [
            'content' => 'required|string|min:1',
        ];
    }

    protected array $messages = [
        'content.required' => 'Mesaj içeriği boş olamaz.',
    ];

    public function mount(int $messageId, array $categories = []): void
    {
        $this->messageId = $messageId;
        $this->message = ForumMessage::find($this->messageId);
        $this->categories = $categories;

        if (!$this->message || !Auth::user()->can('update', $this->message)) {
            // Handle unauthorized access or message not found
            session()->flash('error', __('Mesaj bulunamadı veya düzenleme yetkiniz yok.'));
            $this->dispatch('closeModal'); 
            return;
        }
        $this->content = $this->message->content;
    }

    public function updateMessage(): void
    {
        if (!$this->message || !Auth::user()->can('update', $this->message)) {
            session()->flash('error', __('Mesaj güncellenemedi.'));
            $this->dispatch('closeModal');
            return;
        }

        $this->validate();

        $this->message->content = $this->content;
        $this->message->save();

        session()->flash('message', __('Mesaj başarıyla güncellendi.'));
        $this->dispatch('messageUpdated', $this->message->id);
        $this->dispatch('closeModal');
    }

    public function render(): View
    {
        return view('livewire.edit-message-form');
    }
}
