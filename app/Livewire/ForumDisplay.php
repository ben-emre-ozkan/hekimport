<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ForumCategory;
use App\Models\ForumMessage;
use App\Models\ForumTopic;
use App\Models\ForumTopicUserRead;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ForumDisplay extends Component
{
    use WithPagination;

    // Configuration for lazy loading
    protected $lazyLoadTopics = true;
    protected $perPage = 10;
    
    // Public properties
    public ?int $selectedCategoryId = null;
    public ?int $selectedTopicId = null;
    public string $searchTerm = '';
    public string $filter = 'newest'; // newest, active
    public int $page = 1; // Add explicit page property for pagination

    // For CreateTopicForm modal
    public bool $showCreateTopicModal = false;

    // For Admin Actions / Confirmation Modals
    public bool $showConfirmDeleteMessageModal = false;
    public ?int $messageToDeleteId = null;
    public ?ForumMessage $messageToDelete = null;

    public bool $showConfirmDeleteTopicModal = false;
    public ?int $topicToDeleteId = null;
    public ?ForumTopic $topicToDelete = null;

    public bool $showBanConfirmModal = false;
    public ?User $userToBan = null;
    public bool $showUnbanConfirmModal = false;
    public ?User $userToUnban = null;

    // For Edit Modals
    public bool $showEditMessageModal = false;
    public ?int $messageToEditId = null;

    public bool $showEditTopicModal = false;
    public ?int $topicToEditId = null;

    public $messageContent = '';
    
    public $topicCategoryId = '';
    public $topicTitle = '';
    public $initialMessage = '';
    
    // Edit modal properties
    public $editTopicCategoryId = '';
    public $editTopicTitle = '';
    public $editMessageContent = '';
    
    // Flag to defer loading non-essential content
    public $deferLoading = true;
    
    public $latestActivities = [];
    public $recentNews = [];
    
    protected $rules = [
        'messageContent' => 'required|min:3|max:5000',
        'topicCategoryId' => 'required|exists:forum_categories,id',
        'topicTitle' => 'required|min:3|max:100',
        'initialMessage' => 'required|min:3|max:5000',
        'editMessageContent' => 'required|min:3|max:5000',
        'editTopicCategoryId' => 'required|exists:forum_categories,id',
        'editTopicTitle' => 'required|min:3|max:100',
    ];

    protected $listeners = [
        'topicCreated' => 'refreshAndSelectTopic',
        'messagePosted' => 'refreshAfterMessagePosted', 
        'closeModal' => 'closeAllModals',
        'messageUpdated' => 'refreshAfterUpdate',
        'topicUpdated' => 'refreshAfterUpdate',
        'loadMore' => 'loadMoreTopics',
    ];

    protected $queryString = [
        'selectedTopicId' => ['except' => null, 'as' => 'topic'],
        'searchTerm' => ['except' => '', 'as' => 'q'],
        'filter' => ['except' => 'newest'],
        'page' => ['except' => 1],
        'selectedCategoryId' => ['except' => null, 'as' => 'category'],
    ];

    public function mount(): void
    {
        Log::debug("[ForumDisplay@mount] Mounting component. Passed selectedTopicId: " . ($this->selectedTopicId ?? 'null') . ", selectedCategoryId: " . ($this->selectedCategoryId ?? 'null'));
        if ($this->selectedTopicId) {
            $topic = $this->getCachedTopic($this->selectedTopicId);
            if ($topic) {
                Log::debug("[ForumDisplay@mount] Found topic ID: {$topic->id}. Setting category ID to {$topic->category_id}");
                $this->selectedCategoryId = $topic->category_id;
                if (Auth::check()) $this->markTopicAsRead($topic);
            } else {
                Log::warning("[ForumDisplay@mount] Topic ID {$this->selectedTopicId} passed but not found. Resetting selectedTopicId.");
                $this->selectedTopicId = null; // Topic not found, reset
            }
        }
    }

    protected function getCachedTopic(int $topicId): ?ForumTopic
    {
        return Cache::remember("forum_topic_{$topicId}", 600, function () use ($topicId) {
            return ForumTopic::select(['id', 'title', 'user_id', 'category_id', 'created_at', 'updated_at', 'is_pinned', 'slug'])
                ->with([
                    'user:id,name,profile_photo_path,email', 
                    'category:id,name'
                ])
                ->withCount('messages')
                ->find($topicId);
        });
    }

    protected function getCachedCategories()
    {
        $cacheKey = "forum_categories_{$this->searchTerm}_{$this->filter}";
        
        return Cache::remember($cacheKey, 600, function () {
            // Include topics count without loading entire relationship
            return ForumCategory::orderBy('name')
                ->select(['id', 'name'])
                ->withCount('topics')
                ->get();
        });
    }

    /**
     * Get topics with better caching and pagination at the database level
     */
    protected function getCachedTopics()
    {
        $cacheKey = "forum_topics";
        
        if ($this->selectedCategoryId) {
            $cacheKey .= "_category_{$this->selectedCategoryId}";
        }
        
        $cacheKey .= "_{$this->filter}_page_{$this->page}_search_{$this->searchTerm}";
        
        return Cache::remember($cacheKey, 600, function () {
            $query = ForumTopic::query()
                ->withCount('messages')
                ->with([
                    'user:id,name,profile_photo_path,email', 
                    'category:id,name',
                    'lastMessage' => function($q) {
                        $q->with('user:id,name,profile_photo_path,email')
                            ->latest();
                    }
                ]);
                
            // Apply category filter if selected
            if ($this->selectedCategoryId) {
                $query->where('category_id', $this->selectedCategoryId);
            }
            
            // Apply search filter
            if ($this->searchTerm) {
                $query->where('title', 'like', '%' . $this->searchTerm . '%');
            }
            
            // Apply ordering
            if ($this->filter === 'active') {
                $query->orderByDesc(
                    ForumMessage::select('created_at')
                        ->whereColumn('topic_id', 'forum_topics.id')
                        ->latest()
                        ->take(1)
                )->orderByDesc('is_pinned');
            } else {
                $query->orderByDesc('is_pinned')->orderByDesc('created_at');
            }
            
            // Paginate at the database level - much more efficient
            return $query->paginate($this->perPage);
        });
    }

    public function loadMoreTopics()
    {
        // Signal to frontend that loading is happening
        $this->dispatch('loading');
        
        // Increase the page size instead of disabling lazy loading
        $this->perPage += 10;
        
        // Force refresh to load more topics
        $this->dispatch('$refresh');
        
        // Signal to frontend that loading is complete
        $this->dispatch('loaded');
    }

    public function selectCategory(int $categoryId = null): void
    {
        // Signal to frontend that loading is happening
        $this->dispatch('loading');
        
        try {
            // Reset pagination when changing categories
            $this->resetPage();
            
            // Set the categoryId to trigger state change
            $this->selectedCategoryId = $categoryId;
            
            // Clear any search term to prevent confusion
            $this->searchTerm = '';
            
            // Reset topic selection when changing categories unless explicitly navigating to a topic
            if (!request()->has('topic')) {
                $this->selectedTopicId = null;
            }
            
            // Clear forum caches to ensure fresh data
            $this->clearForumCaches();
            
            // Log for debugging
            logger()->info('Category selected', [
                'category_id' => $categoryId,
                'user_id' => auth()->id() ?? 'guest'
            ]);
            
            // Force refresh to ensure view updates properly
            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            logger()->error('Error selecting category', [
                'category_id' => $categoryId,
                'exception' => $e->getMessage()
            ]);
        } finally {
            // Always signal to frontend that loading is complete
            $this->dispatch('loaded');
        }
    }

    public function updatedSelectedCategoryId($value): void
    {
        if ($value === null) {
            $this->selectCategory(null);
        } else {
            $this->selectCategory((int)$value);
        }
    }

    public function selectTopic(int $topicId): mixed
    {
        try {
            // Reset pagination when changing topics
            $this->resetPage();
            
            // Set the topicId to trigger state change
            $this->selectedTopicId = $topicId;
            
            // Find the topic with eager loaded relations
            $topic = $this->getCachedTopic($topicId);
            
            if (!$topic) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
            }
            
            // Set the category ID to ensure proper state
            $this->selectedCategoryId = $topic->category_id;
            
            // Mark as read for the current user
            if (Auth::check()) {
                $this->markTopicAsRead($topic);
            }
            
            // Clear any search term to prevent confusion
            $this->searchTerm = '';
            
            // In a test environment, don't redirect
            if (app()->environment('testing')) {
                $this->dispatch('$refresh');
                return null;
            }
            
            // Redirect to the new RESTful URL structure
            return redirect()->route('forum.category.topic.show', [
                'category' => $topic->category_id,
                'topic' => $topic->id
            ]);
        } catch (\Exception $e) {
            Log::error('[ForumDisplay@selectTopic] Error selecting topic', [
                'topic_id' => $topicId,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return null for error case
            return null;
        }
    }

    public function markTopicAsRead(ForumTopic $topic): void
    {
        try {
            if (Auth::check() && Schema::hasTable('forum_topic_user_read')) {
                ForumTopicUserRead::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'topic_id' => $topic->id,
                    ],
                    ['last_read_at' => now()]
                );
            }
        } catch (\Exception $e) {
            // Log error but don't propagate exception to avoid breaking functionality
            Log::warning('[ForumDisplay@markTopicAsRead] Error marking topic as read', [
                'user_id' => Auth::id() ?? 'guest',
                'topic_id' => $topic->id,
                'exception' => $e->getMessage()
            ]);
        }
    }
    
    public function openCreateTopicModal(): void
    {
        $this->showCreateTopicModal = true;
    }

    public function updatedShowCreateTopicModal(bool $value): void
    {
        if (!$value) {
             // Potentially refresh topics if a new one was created
            // $this->dispatch('topicCreated'); // Dispatch from CreateTopicForm directly is better
        }
    }

    public function closeAllModals(): void
    {
        $this->showCreateTopicModal = false;
        $this->showConfirmDeleteMessageModal = false;
        $this->showConfirmDeleteTopicModal = false;
        $this->showBanConfirmModal = false;
        $this->showEditMessageModal = false;
        $this->showEditTopicModal = false;
        $this->showUnbanConfirmModal = false;
    }

    public function refreshAndSelectTopic(int $topicId): void
    {
        $this->clearForumCaches();
        $this->selectTopic($topicId);
        $this->dispatch('$refresh');
    }

    public function refreshAfterMessagePosted(): void
    {
        $this->clearForumCaches();
        $this->dispatch('$refresh');
    }

    public function refreshAfterUpdate(): void
    {
        $this->clearForumCaches();
        $this->dispatch('$refresh');
    }

    // Helper method to clear forum caches
    private function clearForumCaches(): void
    {
        // Only clear specific caches based on current state
        if ($this->selectedCategoryId) {
            Cache::forget("forum_topics_category_{$this->selectedCategoryId}_{$this->filter}_page_{$this->page}_search_{$this->searchTerm}");
        } else {
            Cache::forget("forum_topics_{$this->filter}_page_{$this->page}_search_{$this->searchTerm}");
        }
        
        // Clear topic cache only if a topic is selected
        if ($this->selectedTopicId) {
            Cache::forget("forum_topic_{$this->selectedTopicId}");
            Cache::forget("forum_messages_{$this->selectedTopicId}_page_{$this->page}");
        }
        
        // Don't clear all caches every time - only those relevant to current action
        // This prevents unnecessary cache rebuilding
    }

    public function openEditMessageModal(int $messageId): void
    {
        $message = ForumMessage::find($messageId);
        if ($message && Auth::user()->can('update', $message)) {
            $this->messageToEditId = $messageId;
            $this->editMessageContent = $message->content;
            $this->showEditMessageModal = true;
        } else {
            session()->flash('error', __('Bu mesajı düzenleme yetkiniz yok.'));
        }
    }

    public function openEditTopicModal(int $topicId): void
    {
        $topic = ForumTopic::with(['user', 'category'])->withCount('messages')->find($topicId);
        if ($topic && Auth::user()->can('update', $topic)) {
            $this->topicToEditId = $topicId;
            $this->editTopicTitle = $topic->title;
            $this->editTopicCategoryId = $topic->category_id;
            $this->showEditTopicModal = true;
        } else {
            session()->flash('error', __('Bu başlığı düzenleme yetkiniz yok.'));
        }
    }
    
    public function updateMessage(): void
    {
        if (!$this->messageToEditId) {
            $this->dispatch('notify', ['message' => __('Düzenlenecek mesaj bulunamadı.'), 'type' => 'error']);
            return;
        }
        
        $message = ForumMessage::find($this->messageToEditId);
        
        if (!$message || !Auth::user()->can('update', $message)) {
            $this->dispatch('notify', ['message' => __('Bu mesajı düzenleme yetkiniz yok.'), 'type' => 'error']);
            return;
        }
        
        $this->validate([
            'editMessageContent' => 'required|min:3|max:5000',
        ]);
        
        $message->content = $this->editMessageContent;
        $message->save();
        
        $this->messageToEditId = null;
        $this->editMessageContent = '';
        $this->showEditMessageModal = false;
        
        $this->clearForumCaches();
        
        $this->dispatch('notify', ['message' => __('Mesaj başarıyla güncellendi.'), 'type' => 'success']);
        $this->dispatch('$refresh');
    }
    
    public function updateTopic(): void
    {
        if (!$this->topicToEditId) {
            $this->dispatch('notify', ['message' => __('Düzenlenecek başlık bulunamadı.'), 'type' => 'error']);
            return;
        }
        
        $topic = ForumTopic::find($this->topicToEditId);
        
        if (!$topic || !Auth::user()->can('update', $topic)) {
            $this->dispatch('notify', ['message' => __('Bu başlığı düzenleme yetkiniz yok.'), 'type' => 'error']);
            return;
        }
        
        $this->validate([
            'editTopicTitle' => 'required|min:3|max:100',
            'editTopicCategoryId' => 'required|exists:forum_categories,id',
        ]);
        
        $topic->title = $this->editTopicTitle;
        $topic->category_id = $this->editTopicCategoryId;
        $topic->save();
        
        $this->topicToEditId = null;
        $this->editTopicTitle = '';
        $this->editTopicCategoryId = '';
        $this->showEditTopicModal = false;
        
        $this->clearForumCaches();
        
        $this->dispatch('notify', ['message' => __('Başlık başarıyla güncellendi.'), 'type' => 'success']);
        $this->dispatch('$refresh');
    }

    // --- Pin Topic Action ---
    public function togglePinTopic(int $topicId): void
    {
        $topic = ForumTopic::with(['user', 'category'])->withCount('messages')->find($topicId);
        if ($topic && Auth::user()->can('pin', $topic)) {
            $topic->is_pinned = !$topic->is_pinned;
            $topic->save();
            $actionText = $topic->is_pinned ? __('sabitlendi') : __('sabitlemesi kaldırıldı');
            
            // Clear cache after modifying data
            $this->clearForumCaches();
            
            $this->dispatch('notify', ['message' => __('Başlık başarıyla :actionText.', ['actionText' => $actionText]), 'type' => 'success']);
            $this->dispatch('$refresh');
        } else {
            $this->dispatch('notify', ['message' => __('Başlığı sabitleme/kaldırma yetkiniz yok.'), 'type' => 'error']);
        }
    }

    // --- Post Message Action ---
    public function postMessage(): void
    {
        if (!$this->selectedTopicId) {
            $this->dispatch('notify', ['message' => __('Önce bir başlık seçmelisiniz.'), 'type' => 'error']);
            return;
        }
        
        if (!Auth::check()) {
            $this->dispatch('notify', ['message' => __('Mesaj göndermek için giriş yapmalısınız.'), 'type' => 'error']);
            return;
        }
        
        // Validate the message content
        $this->validate([
            'messageContent' => 'required|min:3|max:5000',
        ]);
        
        try {
            // Create new message
            $message = new ForumMessage();
            $message->topic_id = $this->selectedTopicId;
            $message->user_id = Auth::id();
            $message->content = $this->messageContent;
            $message->save();
            
            // Reset the message content
            $this->reset('messageContent');
            
            // Clear cache after posting
            $this->clearForumCaches();
            
            $this->dispatch('notify', ['message' => __('Mesajınız başarıyla gönderildi.'), 'type' => 'success']);
            
            // Refresh the component to show the new message
            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            logger()->error('Error posting message', [
                'user_id' => Auth::id(),
                'topic_id' => $this->selectedTopicId,
                'exception' => $e->getMessage()
            ]);
            
            $this->dispatch('notify', ['message' => __('Mesaj gönderilirken bir hata oluştu.'), 'type' => 'error']);
        }
    }

    // --- Create Topic Action ---
    public function createTopic(): void
    {
        if (!Auth::check()) {
            $this->dispatch('notify', ['message' => __('Başlık oluşturmak için giriş yapmalısınız.'), 'type' => 'error']);
            return;
        }
        
        // Validate topic form fields
        $this->validate([
            'topicCategoryId' => 'required|exists:forum_categories,id',
            'topicTitle' => 'required|min:3|max:100',
            'initialMessage' => 'required|min:3|max:5000',
        ]);
        
        try {
            // Begin transaction to ensure both topic and message are created
            \DB::beginTransaction();
            
            // Create new topic
            $topic = new ForumTopic();
            $topic->category_id = $this->topicCategoryId;
            $topic->user_id = Auth::id();
            $topic->title = $this->topicTitle;
            $topic->is_pinned = Auth::user()->hasRole('admin'); // Only admins can create pinned topics
            $topic->slug = \Str::slug($this->topicTitle) . '-' . time(); // Add a timestamp to ensure uniqueness
            $topic->save();
            
            // Create initial message
            $message = new ForumMessage();
            $message->topic_id = $topic->id;
            $message->user_id = Auth::id();
            $message->content = $this->initialMessage;
            $message->save();
            
            \DB::commit();
            
            // Reset form fields
            $this->reset(['topicCategoryId', 'topicTitle', 'initialMessage']);
            $this->showCreateTopicModal = false;
            
            // Clear cache and refresh
            $this->clearForumCaches();
            
            $this->dispatch('notify', ['message' => __('Başlık başarıyla oluşturuldu.'), 'type' => 'success']);
            
            // Select the new topic
            $this->refreshAndSelectTopic($topic->id);
        } catch (\Exception $e) {
            \DB::rollBack();
            
            logger()->error('Error creating topic', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage()
            ]);
            
            $this->dispatch('notify', ['message' => __('Başlık oluşturulurken bir hata oluştu.'), 'type' => 'error']);
        }
    }

    /**
     * Load deferred content - called via wire:init when content becomes visible
     */
    public function loadDeferredContent(): void
    {
        try {
            // Load latest activities and news content for sidebar
            $this->getLatestActivities();
            $this->getRecentNews();
            
            // Set flag to indicate content is loaded
            $this->deferLoading = false;
            
            // Dispatch event for UI updates
            $this->dispatch('deferredContentLoaded');
            
            // Force refresh to ensure proper rendering
            $this->dispatch('$refresh');
            
            Log::debug("[ForumDisplay@loadDeferredContent] Deferred content loaded successfully");
        } catch (\Exception $e) {
            Log::error("[ForumDisplay@loadDeferredContent] Error loading deferred content: " . $e->getMessage());
        }
    }
    
    /**
     * Get forum stats with optimal caching
     */
    protected function getForumStats(): array
    {
        return Cache::remember('forum_stats', 3600, function() {
            return [
                'topic_count' => ForumTopic::count(),
                'message_count' => ForumMessage::count(),
                'user_count' => User::count(),
            ];
        });
    }

    /**
     * Get latest forum activities with caching
     */
    protected function getLatestActivities(): void
    {
        $cacheKey = "forum_latest_activities";
        
        $this->latestActivities = Cache::remember($cacheKey, 600, function () {
            // Combine recent topics and messages
            $activities = collect();
            
            // Get latest topics (limit 5)
            $latestTopics = ForumTopic::with(['user:id,name,profile_photo_path', 'category:id,name'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($topic) {
                    return (object)[
                        'id' => $topic->id,
                        'type' => 'topic_created',
                        'title' => $topic->title,
                        'topic_id' => $topic->id,
                        'category_id' => $topic->category_id,
                        'user' => $topic->user,
                        'created_at' => $topic->created_at,
                    ];
                });
            
            $activities = $activities->concat($latestTopics);
            
            // Get latest messages (limit 5)
            $latestMessages = ForumMessage::with(['user:id,name,profile_photo_path', 'topic:id,title,category_id'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($message) {
                    return (object)[
                        'id' => $message->id,
                        'type' => 'message_posted',
                        'title' => $message->topic->title ?? 'Unknown Topic',
                        'topic_id' => $message->topic_id,
                        'category_id' => $message->topic->category_id ?? null,
                        'user' => $message->user,
                        'created_at' => $message->created_at,
                    ];
                });
            
            $activities = $activities->concat($latestMessages);
            
            // Sort by created_at and limit to 10
            return $activities->sortByDesc('created_at')->take(10)->values();
        });
    }
    
    /**
     * Get recent news (placeholder for actual implementation)
     */
    protected function getRecentNews(): void
    {
        // In a real implementation, this might fetch from a news table
        // For now, we'll use static news items as shown in the template
        $this->recentNews = [
            [
                'title' => 'Hekimport.com şimdi aktif!',
                'date' => '1 Haziran 2023',
                'author' => 'Hekimport Yönetimi',
                'content' => 'Değerli diş hekimleri ve diş hekimliği öğrencileri, Hekimport.com platformumuz artık tamamen aktif durumdadır.',
                'is_new' => true,
            ],
            [
                'title' => 'Yeni Forum Özellikleri Eklendi',
                'date' => '15 Mayıs 2023',
                'author' => 'Teknik Ekip',
                'content' => 'Forum bölümümüze yeni özellikler ekledik.',
                'is_new' => false,
            ],
        ];
    }

    public function render(): View
    {
        $startTime = microtime(true);
        Log::debug("[ForumDisplay@render] Started rendering. SelectedTopicId: " . ($this->selectedTopicId ?? 'null') . ", SelectedCategoryId: " . ($this->selectedCategoryId ?? 'null'));

        // Check if the forum_categories table exists before querying it
        if (!Schema::hasTable('forum_categories')) {
            Log::debug("[ForumDisplay@render] Schema missing, returning empty collections");
            return view('livewire.forum-display', [
                'categories' => collect([]),
                'selectedTopic' => null,
                'messages' => collect([]),
                'topicsGrouped' => ['pinned' => collect([]), 'regular' => collect([])],
                'topics' => collect([]),
                'topicCount' => 0,
                'messageCount' => 0,
                'userCount' => 0,
                'latestActivities' => collect([]),
                'isLazyLoading' => $this->lazyLoadTopics,
            ]);
        }
        
        // Signal that loading has started
        $this->dispatch('loading');
        
        $categoriesStart = microtime(true);
        // Get categories using our optimized cached method
        $categories = $this->getCachedCategories();
        $categoriesTime = round((microtime(true) - $categoriesStart) * 1000, 2);
        Log::debug("[ForumDisplay@render] Loaded categories in {$categoriesTime}ms");
        
        $topicsStart = microtime(true);
        // Get topics using our new optimized method
        $topics = $this->getCachedTopics();
        $topicsTime = round((microtime(true) - $topicsStart) * 1000, 2);
        Log::debug("[ForumDisplay@render] Loaded topics in {$topicsTime}ms");
        
        $selectedTopic = null;
        $messages = collect([]);
        
        // Process topics into pinned and regular groups
        $topicsGrouped = [
            'pinned' => $topics->where('is_pinned', true),
            'regular' => $topics->where('is_pinned', false)
        ];

        // If a topic is selected, fetch it with its messages
        if ($this->selectedTopicId) {
            $topicStart = microtime(true);
            $selectedTopic = $this->getCachedTopic($this->selectedTopicId);
            $topicTime = round((microtime(true) - $topicStart) * 1000, 2);
            Log::debug("[ForumDisplay@render] Loaded selected topic in {$topicTime}ms");
            
            if ($selectedTopic) {
                $messagesStart = microtime(true);
                // Use lazy loading for messages with pagination
                $messages = Cache::remember("forum_messages_{$this->selectedTopicId}_page_{$this->page}", 600, function () {
                    return ForumMessage::where('topic_id', $this->selectedTopicId)
                        ->select(['id', 'topic_id', 'user_id', 'content', 'created_at', 'updated_at'])
                        ->with(['user:id,name,profile_photo_path,email'])
                        ->orderBy('created_at', 'asc')
                        ->paginate($this->perPage);
                });
                $messagesTime = round((microtime(true) - $messagesStart) * 1000, 2);
                Log::debug("[ForumDisplay@render] Loaded messages in {$messagesTime}ms");
                
                if (Auth::check()) {
                    $this->markTopicAsRead($selectedTopic);
                }
            }
        }
        
        $statsStart = microtime(true);
        // Get forum stats (optimized)
        $stats = $this->getForumStats();
        $topicCount = $stats['topic_count'];
        $messageCount = $stats['message_count'];
        $userCount = $stats['user_count'];
        $statsTime = round((microtime(true) - $statsStart) * 1000, 2);
        Log::debug("[ForumDisplay@render] Loaded forum stats in {$statsTime}ms");
        
        // Initialize data containers with empty collections
        $latestActivities = collect([]);
        
        // Only load non-essential data if not deferred or explicitly requested
        if (!$this->deferLoading) {
            Log::debug("[ForumDisplay@render] Loading deferred content");
            $deferredStart = microtime(true);
            
            // Get latest activities - longer cache time
            if (Schema::hasTable('forum_topics') && Schema::hasTable('forum_messages')) {
                $latestActivities = Cache::remember('forum_latest_activities', 1800, function () {
                    // More selective fields for better performance
                    $latestTopics = ForumTopic::select(['id', 'title', 'user_id', 'category_id', 'created_at', 'slug'])
                        ->with([
                            'user:id,name,profile_photo_path,email', 
                            'category:id,name'
                        ])
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function($topic) {
                            return (object)[
                                'user' => $topic->user,
                                'topic_id' => $topic->id,
                                'category_id' => $topic->category_id,
                                'title' => $topic->title,
                                'created_at' => $topic->created_at,
                                'type' => 'topic_created'
                            ];
                        });
                        
                    $latestMessages = ForumMessage::select(['id', 'topic_id', 'user_id', 'created_at'])
                        ->with([
                            'user:id,name,profile_photo_path,email', 
                            'topic:id,title,category_id,user_id'
                        ])
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function($message) {
                            return (object)[
                                'user' => $message->user,
                                'topic_id' => $message->topic_id,
                                'category_id' => $message->topic->category_id ?? null,
                                'title' => $message->topic->title ?? '',
                                'created_at' => $message->created_at,
                                'type' => 'message_posted'
                            ];
                        });
                        
                    return $latestTopics->merge($latestMessages)
                        ->sortByDesc('created_at')
                        ->take(10)
                        ->values();
                });
            }
            
            $deferredTime = round((microtime(true) - $deferredStart) * 1000, 2);
            Log::debug("[ForumDisplay@render] Loaded deferred content in {$deferredTime}ms");
        } else {
            Log::debug("[ForumDisplay@render] Skipping deferred content loading");
        }
        
        $totalTime = round((microtime(true) - $startTime) * 1000, 2);
        Log::debug("[ForumDisplay@render] Total render time: {$totalTime}ms");

        // Signal that loading is complete
        $this->dispatch('loaded');

        return view('livewire.forum-display', [
            'categories' => $categories,
            'selectedTopic' => $selectedTopic,
            'messages' => $messages,
            'topicsGrouped' => $topicsGrouped,
            'topics' => $topics,
            'topicCount' => $topicCount,
            'messageCount' => $messageCount,
            'userCount' => $userCount,
            'latestActivities' => $latestActivities,
            'isLazyLoading' => $this->lazyLoadTopics,
            'deferLoading' => $this->deferLoading,
        ]);
    }
}

