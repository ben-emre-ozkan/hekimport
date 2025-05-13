<x-forum-layout>
    <!-- Forum Three-Column Layout -->
    <div class="forum-container">
        @livewire('forum-display', ['selectedTopicId' => $selectedTopicId ?? null, 'selectedCategoryId' => $selectedCategoryId ?? null])
    </div>
</x-forum-layout> 