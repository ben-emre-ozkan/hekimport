<style>
    /* Custom CSS to ensure proper forum display */
    /* Display all columns in a row on larger screens, stack on mobile */
    .forum-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem; /* Increased gap for better spacing */
        width: 100%;
        padding: 0.5rem;
        box-sizing: border-box;
        justify-content: space-between;
        min-width: 100%;
        overflow-x: hidden;
    }
    
    /* Set widths for different screen sizes */
    .forum-left-column {
        flex: 0 0 100%;
        width: 100%;
        margin-bottom: 1rem;
        box-sizing: border-box;
        overflow-y: auto;
    }
    
    .forum-middle-column {
        flex: 0 0 100%;
        width: 100%;
        margin-bottom: 1rem;
        order: 1; /* Ensure it's visible before the right column on mobile */
        box-sizing: border-box;
        overflow-y: auto;
    }
    
    .forum-right-column {
        flex: 0 0 100%;
        width: 100%;
        order: 2; /* Push to end on mobile */
        box-sizing: border-box;
        overflow-y: auto;
    }
    
    /* Topics list container */
    .topics-list-container {
        min-height: 300px;
        max-height: 550px;
        overflow-y: auto;
        padding: 0.75rem;
        border: 1px solid #f3f4f6;
        border-radius: 0.5rem;
        background-color: #f9fafb;
    }
    
    /* Small screens (portrait phones) */
    @media (max-width: 640px) {
        .forum-container {
            flex-direction: column;
            gap: 1rem;
        }
        
        .forum-left-column, 
        .forum-middle-column, 
        .forum-right-column {
            flex: 0 0 100%;
            width: 100%;
            margin-bottom: 1rem;
        }
        
        /* Display columns in a specific order on small screens */
        .forum-left-column {
            order: 1;
        }
        
        .forum-middle-column {
            order: 2;
        }
        
        .forum-right-column {
            order: 3;
        }
    }
    
    /* Tablet and larger screens */
    @media (min-width: 768px) {
        .forum-container {
            padding: 0.5rem;
            gap: 1.5rem;
        }
        
        .forum-left-column {
            flex: 0 0 calc(25% - 1rem);
            width: calc(25% - 1rem);
            margin-bottom: 0;
        }
        
        .forum-middle-column {
            flex: 0 0 calc(50% - 1rem);
            width: calc(50% - 1rem);
            margin-bottom: 0;
            order: unset; /* Reset order for desktop */
            height: calc(100vh - 130px); /* Set fixed height for desktop view */
            overflow-y: auto; /* Make scrollable */
            padding-right: 0.75rem; /* Reduced padding for scrollbar to ensure 50% width is honored */
            /* Add smooth scrolling for better UX */
            scroll-behavior: smooth;
        }
        
        .forum-right-column {
            flex: 0 0 calc(25% - 1rem);
            width: calc(25% - 1rem);
            order: unset; /* Reset order for desktop */
        }
        
        /* Inner container for middle column content to add proper spacing */
        .forum-middle-content {
            padding-right: 0.5rem;
            height: 100%;
        }
    }
    
    /* Large screens */
    @media (min-width: 1024px) {
        .forum-container {
            padding: 0.5rem;
            width: 99%;
            margin: 0 auto;
            gap: 1.5rem;
        }
        
        .forum-left-column {
            flex: 0 0 calc(25% - 1rem);
            width: calc(25% - 1rem);
        }
        
        .forum-middle-column {
            flex: 0 0 calc(50% - 1rem);
            width: calc(50% - 1rem);
            height: calc(100vh - 130px); /* Set fixed height for desktop view */
            overflow-y: auto; /* Make scrollable */
        }
        
        .forum-right-column {
            flex: 0 0 calc(25% - 1rem);
            width: calc(25% - 1rem);
        }
    }
    
    /* Extra large screens */
    @media (min-width: 1280px) {
        .forum-container {
            padding: 0.5rem;
            width: 99%;
            max-width: 1800px;
            margin: 0 auto;
            gap: 1.5rem;
        }
        
        .forum-left-column {
            flex: 0 0 calc(25% - 1rem);
            width: calc(25% - 1rem);
        }
        
        .forum-middle-column {
            flex: 0 0 calc(50% - 1rem);
            width: calc(50% - 1rem);
            height: calc(100vh - 130px); /* Set fixed height for desktop view */
            overflow-y: auto; /* Make scrollable */
        }
        
        .forum-right-column {
            flex: 0 0 calc(25% - 1rem);
            width: calc(25% - 1rem);
        }
    }
    
    /* Ensure columns have minimum height */
    .forum-left-column, .forum-middle-column, .forum-right-column {
        min-height: 300px;
        display: block;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 0.75rem;
        box-sizing: border-box;
    }
    
    /* Modernized News item styles */
    .news-item {
        border-left: 3px solid #00c8b3;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: white;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }
    
    .news-item::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #00c8b3, #0099e5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .news-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        border-left-color: #0099e5;
    }
    
    .news-item:hover::before {
        opacity: 1;
    }
    
    .news-item h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #222;
        font-size: 1rem;
        position: relative;
        padding-bottom: 0.25rem;
    }
    
    .news-item h3::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 30px;
        height: 2px;
        background: linear-gradient(90deg, #00c8b3, #0099e5);
    }
    
    .news-item-meta {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        color: #666;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 0.5rem;
    }
    
    .news-item-date {
        margin-right: 1rem;
        display: flex;
        align-items: center;
    }
    
    .news-item-author {
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .news-item-content {
        font-size: 0.85rem;
        line-height: 1.5;
        color: #444;
    }
    
    .news-item-content p {
        margin-bottom: 0.5rem;
    }
    
    .news-item-content ul {
        margin-left: 0.5rem;
    }
    
    .news-item-content ul li {
        margin-bottom: 0.25rem;
    }
    
    /* Topic hover styles - Improved */
    .topic-row {
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    
    .topic-row:hover {
        box-shadow: 0 4px 10px -1px rgba(0, 0, 0, 0.1), 0 2px 6px -1px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
        border-color: #00c8b3;
    }
    
    .topic-row:hover::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0.5rem;
        pointer-events: none;
        box-shadow: inset 0 0 0 2px rgba(0, 200, 179, 0.4);
    }
    
    .topic-row:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    }
    
    .topic-row h3 {
        color: #00c8b3;
    }
    
    /* Loading animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .animate-pulse {
        animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Forum Button Style */
    .forum-btn {
        background-image: linear-gradient(to right, #00c8b3, #0099e5);
        color: white;
        transition: all 0.3s ease;
    }
    
    .forum-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    /* Scrollbar styles - CONSISTENT ACROSS ALL COLUMNS */
    .forum-left-column::-webkit-scrollbar,
    .forum-middle-column::-webkit-scrollbar,
    .forum-right-column::-webkit-scrollbar,
    .topics-list-container::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .forum-left-column::-webkit-scrollbar-track,
    .forum-middle-column::-webkit-scrollbar-track,
    .forum-right-column::-webkit-scrollbar-track,
    .topics-list-container::-webkit-scrollbar-track {
        background: rgba(241, 241, 241, 0.5);
        border-radius: 3px;
    }
    
    .forum-left-column::-webkit-scrollbar-thumb,
    .forum-middle-column::-webkit-scrollbar-thumb,
    .forum-right-column::-webkit-scrollbar-thumb,
    .topics-list-container::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #00c8b3, #0099e5);
        border-radius: 3px;
    }
    
    .forum-left-column::-webkit-scrollbar-thumb:hover,
    .forum-middle-column::-webkit-scrollbar-thumb:hover,
    .forum-right-column::-webkit-scrollbar-thumb:hover,
    .topics-list-container::-webkit-scrollbar-thumb:hover {
        background: #0099e5;
    }

    /* Firefox scrollbar support */
    .forum-middle-column, .forum-left-column, .forum-right-column, .topics-list-container {
        scrollbar-width: thin;
        scrollbar-color: #00c8b3 #f1f1f1;
    }

    /* Custom CSS for mobile optimization */
    @media (max-width: 767px) {
        .forum-container {
            display: block;
            padding: 0.5rem;
        }
        
        .forum-left-column,
        .forum-middle-column,
        .forum-right-column {
            width: 100%;
            margin-bottom: 1rem;
            max-width: 100%;
            overflow-y: visible;
            height: auto;
            max-height: none;
        }
        
        .forum-column-header h2 {
            font-size: 1rem;
        }
        
        .topics-list-container {
            max-height: 400px;
        }
        
        /* Ensure proper stacking order on mobile */
        .forum-left-column {
            order: 1;
        }
        
        .forum-middle-column {
            order: 2;
        }
        
        .forum-right-column {
            order: 3;
        }
    }
    
    /* Add visibility indicator */
    .column-indicator {
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 999;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border: 1px solid #e2e8f0;
    }
    
    /* Forum column header styling */
    .forum-column-header h2 {
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Fix for news item badges */
    .news-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 0.7rem;
        line-height: 1;
        padding: 3px 6px;
        border-radius: 999px;
        z-index: 1;
    }
    
    /* Clickable topic button */
    .click-view-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        margin-top: 0.75rem;
        background: linear-gradient(90deg, #00c8b3, #0099e5);
        color: white;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        opacity: 0.9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .click-view-button:hover {
        transform: translateY(-2px);
        opacity: 1;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    /* Improve link styling */
    .topic-row, .topic-link {
        text-decoration: none !important;
        color: inherit;
    }

    /* Clickable topic styles with enhanced appearance */
    .topic-clickable {
        transition: all 0.2s ease;
        cursor: pointer !important;
        position: relative;
    }
    
    .topic-clickable:hover {
        background-color: #f3f9fb;
        box-shadow: 0 4px 12px rgba(0, 200, 179, 0.1);
        transform: translateY(-2px);
    }
    
    .topic-clickable::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #00c8b3, #0099e5);
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .topic-clickable:hover::after {
        opacity: 1;
    }

    /* Apply border-box to all forum elements for better sizing */
    .forum-left-column, 
    .forum-middle-column, 
    .forum-right-column, 
    .forum-container * {
        box-sizing: border-box;
    }

    /* Add fixed heights for desktop columns */
    @media (min-width: 768px) {
        .forum-left-column, 
        .forum-middle-column,
        .forum-right-column {
            height: calc(100vh - 130px);
            max-height: calc(100vh - 130px);
            overflow-y: auto;
        }
    }

    /* Add box-sizing to all elements */
    *, *::before, *::after {
        box-sizing: border-box;
    }
    
    /* Add max-height with overflow for columns on all screens */
    .forum-left-column, 
    .forum-middle-column,
    .forum-right-column {
        max-height: calc(100vh - 130px);
        overflow-y: auto;
    }
    
    /* Ensure content doesn't overflow its container */
    .forum-container {
        overflow-x: hidden;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Add default spacing */
    .forum-container > * {
        padding: 1rem;
    }
</style>

<div x-data="forumContent" 
     x-init="
        $nextTick(() => {
            // Initial loading is complete
            $wire.dispatch('loaded');
        })
     ">
    
    <!-- Loading Indicator -->
    <div wire:loading.delay class="fixed top-0 left-0 right-0 bg-gradient-to-r from-[#00c8b3] to-[#0099e5] h-1 z-50 animate-pulse"></div>
    
    <!-- Global Loading Overlay -->
    <div 
        x-show="isLoading" 
        x-transition.opacity.duration.300ms 
        class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-40"
        style="display: none;"
    >
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
            <div class="flex items-center justify-center space-x-3">
                <svg class="animate-spin h-8 w-8 text-[#00c8b3]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-medium text-gray-800">{{ __('Yükleniyor...') }}</span>
            </div>
        </div>
    </div>
    
    <!-- Debug Column Indicator (only visible during development) -->
    @if(config('app.debug'))
    <div class="column-indicator">
        <span class="text-sm">Forum Columns: <span class="font-semibold text-green-600">Active</span></span>
    </div>
    @endif
    
    <div class="forum-container">
        <!-- Left Column - Categories -->
        <div class="forum-left-column">
            <!-- Column Header -->
            <div class="forum-column-header mb-4 w-full">
                <h2 class="text-lg font-bold text-white bg-gradient-to-r from-[#00c8b3] to-[#0099e5] py-3 px-4 rounded-lg shadow-sm flex items-center w-full">
                    <i class="fas fa-layer-group mr-2 text-white"></i>
                    {{ __('Forum Kategorileri') }}
                </h2>
            </div>
            
            <!-- Create Topic Button -->
            <button 
                wire:click="openCreateTopicModal" 
                class="w-full py-3 px-4 mb-6 forum-btn rounded-md flex items-center justify-center shadow-sm hover:shadow"
                dusk="new-topic-button"
                wire:loading.attr="disabled"
            >
                <i class="fas fa-plus-circle mr-2 text-lg"></i>
                <span class="font-medium">{{ __('Yeni Başlık') }}</span>
            </button>
            
            <!-- Search Box -->
            <div class="mb-6">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.debounce.750ms="searchTerm" 
                        placeholder="{{ __('Forum\'da Ara...') }}" 
                        class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00c8b3] focus:border-transparent transition shadow-sm"
                        dusk="search-input"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    @if($searchTerm)
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button wire:click="$set('searchTerm', '')" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times-circle"></i>
                        </button>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Filter Dropdown - optimized with defer -->
            <div class="mb-6">
                <div class="flex items-center">
                <select 
                        wire:model.defer="filter" 
                        wire:change="$refresh"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00c8b3] focus:border-transparent shadow-sm transition"
                    dusk="filter-select"
                >
                    <option value="newest">{{ __('En Yeni') }}</option>
                    <option value="active">{{ __('En Aktif') }}</option>
                </select>
                </div>
            </div>
            
            <!-- Categories List -->
            <div class="space-y-2 mb-6">
                <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-folder mr-2 text-[#00c8b3]"></i>
                    {{ __('Kategoriler') }}
                </h3>
                
                <!-- All Categories Link -->
                <a 
                    href="{{ url()->current() }}" 
                    wire:click.prevent="selectCategory(null)" 
                    class="block px-4 py-2.5 rounded-md transition-all duration-200 ease-in-out cursor-pointer {{ !$selectedCategoryId ? 'bg-gradient-to-r from-[#00c8b3] to-[#0099e5] text-white font-medium shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }} mb-1 hover:shadow-md"
                    dusk="all-categories-link"
                    wire:loading.class="opacity-50 pointer-events-none"
                >
                    <div class="flex items-center justify-between">
                        <span>{{ __('Tüm Kategoriler') }}</span>
                        <i class="fas fa-chevron-right text-xs {{ !$selectedCategoryId ? 'text-white' : 'text-gray-400' }}"></i>
                    </div>
                </a>
                
                @forelse ($categories as $category)
                    <a 
                        href="{{ route('forum.category.show', ['category' => $category->id]) }}" 
                        wire:click.prevent="selectCategory({{ $category->id }})" 
                        class="block px-4 py-2.5 rounded-md transition-all duration-200 ease-in-out cursor-pointer {{ $selectedCategoryId == $category->id ? 'bg-gradient-to-r from-[#00c8b3] to-[#0099e5] text-white font-medium shadow-sm' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 hover:scale-[1.02] transform' }} hover:shadow-md"
                        dusk="category-link-{{ $category->id }}"
                        wire:loading.class="opacity-50 pointer-events-none"
                        wire:key="category-{{ $category->id }}"
                    >
                        <div class="flex items-center justify-between">
                            <span>{{ $category->name }}</span>
                            <span class="px-2 py-0.5 text-xs rounded-full {{ $selectedCategoryId == $category->id ? 'bg-white bg-opacity-20 text-white' : 'bg-white text-gray-700 shadow-sm' }}">
                                {{ $category->topics_count }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-folder-open text-gray-300 text-2xl mb-2"></i>
                        <p>{{ __('Henüz kategori bulunmamaktadır.') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Forum Statistics -->
            <div class="mt-6">
                <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-[#00c8b3]"></i>
                    {{ __('Forum İstatistikleri') }}
                </h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">{{ __('Toplam Başlık') }}</span>
                        <span class="font-semibold text-gray-800">{{ $topicCount }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">{{ __('Toplam Mesaj') }}</span>
                        <span class="font-semibold text-gray-800">{{ $messageCount }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">{{ __('Kategori Sayısı') }}</span>
                        <span class="font-semibold text-gray-800">{{ $categories->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-600">{{ __('Kullanıcı Sayısı') }}</span>
                        <span class="font-semibold text-gray-800">{{ $userCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Column - Topics List or Selected Topic Content -->
        <div class="forum-middle-column">
            <!-- Column Header -->
            <div class="forum-column-header mb-4 w-full">
                <h2 class="text-lg font-bold text-white bg-gradient-to-r from-[#00c8b3] to-[#0099e5] py-3 px-4 rounded-lg shadow-sm flex items-center w-full">
                    <i class="fas fa-list-alt mr-2 text-white"></i>
                    @if($selectedTopic)
                        {{ __('Konu Detayı') }}
                    @else
                        {{ __('Başlık Listesi') }}
                    @endif
                </h2>
            </div>
            
            <div class="forum-middle-content">
                @if($selectedTopic)
                    <!-- Selected Topic Section -->
                    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                        <div class="flex justify-between items-start md:items-center flex-col md:flex-row gap-4 md:gap-0">
                            <h2 class="text-2xl font-bold text-gray-800 bg-gradient-to-r from-[#00c8b3] to-[#0099e5] bg-clip-text text-transparent">{{ $selectedTopic->title }}</h2>
                            <div class="flex space-x-2">
                                @if(Auth::user() && Auth::user()->hasRole('admin'))
                                    <button 
                                        wire:click="togglePinTopic({{ $selectedTopic->id }})" 
                                        class="px-3 py-1.5 forum-btn text-sm rounded-md flex items-center space-x-1 shadow-sm"
                                        dusk="pin-topic-button"
                                        wire:loading.attr="disabled"
                                    >
                                        @if($selectedTopic->is_pinned)
                                            <i class="fas fa-thumbtack mr-1"></i>
                                            <span>{{ __('Sabitlemeyi Kaldır') }}</span>
                                        @else
                                            <i class="fas fa-thumbtack mr-1"></i>
                                            <span>{{ __('Sabitle') }}</span>
                                        @endif
                                    </button>
                                    
                                    <button 
                                        wire:click="confirmDeleteTopic({{ $selectedTopic->id }})" 
                                        class="px-3 py-1.5 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition flex items-center shadow-sm"
                                        dusk="delete-topic-button"
                                        wire:loading.attr="disabled"
                                    >
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        <span>{{ __('Sil') }}</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-y-2 text-sm text-gray-500 mt-3 border-b border-gray-100 pb-3">
                            <div class="flex items-center mr-4 bg-gray-50 py-1 px-2 rounded">
                                <i class="fas fa-folder text-[#00c8b3] mr-1"></i>
                                <span>{{ $selectedTopic->category->name }}</span>
                            </div>
                            <div class="flex items-center mr-4 bg-gray-50 py-1 px-2 rounded">
                                <i class="fas fa-user text-[#00c8b3] mr-1"></i>
                                <span>{{ $selectedTopic->user->name }}</span>
                            </div>
                            <div class="flex items-center bg-gray-50 py-1 px-2 rounded">
                                <i class="fas fa-calendar-alt text-[#00c8b3] mr-1"></i>
                                <span>{{ $selectedTopic->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Section - optimized with deferred loading -->
                    <div wire:init="$emitSelf('loaded')" class="space-y-6 mb-8">
                        @forelse ($messages as $message)
                            <div 
                                wire:key="message-{{ $message->id }}"
                                class="bg-white border border-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200"
                            >
                                <div class="flex flex-col md:flex-row md:items-start p-5">
                                    <!-- User Avatar & Info -->
                                    <div class="flex md:flex-col md:flex-shrink-0 items-center md:items-center md:mr-6 mb-4 md:mb-0 md:w-32">
                                        <img 
                                            loading="lazy" 
                                            src="{{ $message->user->profile_photo_url }}" 
                                            alt="{{ $message->user->name }}" 
                                            class="h-14 w-14 rounded-full user-avatar mb-2 shadow-md"
                                            width="56" 
                                            height="56"
                                            onerror="this.onerror=null;this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTYiIGhlaWdodD0iNTYiIHZpZXdCb3g9IjAgMCA1NiA1NiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNTYiIGhlaWdodD0iNTYiIGZpbGw9IiNDQ0NDQ0MiLz48cGF0aCBkPSJNMjggMjhDMzMuNTIyOCAyOCAzOCAyMy41MjI4IDM4IDE4QzM4IDEyLjQ3NzIgMzMuNTIyOCA4IDI4IDhDMjIuNDc3MiA4IDE4IDEyLjQ3NzIgMTggMThDMTggMjMuNTIyOCAyMi40NzcyIDI4IDI4IDI4WiIgZmlsbD0id2hpdGUiLz48cGF0aCBkPSJNMzggMzRIMThDMTMuNTgxNyAzNCAxMCAzNy41ODE3IDEwIDQyVjQ4SDExSDQ1SDQ2VjQyQzQ2IDM3LjU4MTcgNDIuNDE4MyAzNCAzOCAzNFoiIGZpbGw9IndoaXRlIi8+PC9zdmc+';"
                                        >
                                        <div class="ml-3 md:ml-0 text-xs text-gray-500 md:mt-2 text-center">
                                            <div class="font-medium text-gray-800 md:text-center text-sm">{{ $message->user->name }}</div>
                                            @if(isset($message->user->message_count) && $message->user->message_count > 0)
                                                <span class="block mt-1"><span class="font-semibold">{{ $message->user->message_count }}</span> mesaj</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Message Content -->
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center md:hidden">
                                                @if(isset($message->user->is_banned_from_forum) && $message->user->is_banned_from_forum)
                                                    <span class="ml-2 text-xs font-medium text-red-500 px-2 py-0.5 bg-red-50 rounded-full">{{ __('YASAKLI') }}</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded">{{ $message->created_at->format('d.m.Y H:i') }}</div>
                                        </div>
                                        
                                        <div class="prose prose-sm max-w-none text-gray-700 bg-gray-50 p-5 rounded-lg border border-gray-100">
                                            {!! nl2br(e($message->content)) !!}
                                        </div>
                                        
                                        @if(Auth::user())
                                            <div class="mt-4 flex justify-end space-x-3">
                                                @if(Auth::user()->can('update', $message))
                                                    <button 
                                                        wire:click="openEditMessageModal({{ $message->id }})" 
                                                        class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded transition text-gray-700 flex items-center"
                                                        wire:loading.attr="disabled"
                                                    >
                                                        <i class="fas fa-edit mr-1"></i> {{ __('Düzenle') }}
                                                    </button>
                                                @endif
                                                
                                                @if(Auth::user()->can('delete', $message))
                                                    <button 
                                                        wire:click="confirmDeleteMessage({{ $message->id }})" 
                                                        class="text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded transition text-red-600 flex items-center"
                                                        wire:loading.attr="disabled"
                                                    >
                                                        <i class="fas fa-trash-alt mr-1"></i> {{ __('Sil') }}
                                                    </button>
                                                @endif
                                                
                                                @if(Auth::user()->hasRole('admin') && !(isset($message->user->is_banned_from_forum) && $message->user->is_banned_from_forum))
                                                    <button 
                                                        wire:click="confirmBanUser({{ $message->user->id }})" 
                                                        class="text-xs bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded transition text-orange-600 flex items-center"
                                                        wire:loading.attr="disabled"
                                                    >
                                                        <i class="fas fa-ban mr-1"></i> {{ __('Kullanıcıyı Yasakla') }}
                                                    </button>
                                                @elseif(Auth::user()->hasRole('admin') && isset($message->user->is_banned_from_forum) && $message->user->is_banned_from_forum)
                                                    <button 
                                                        wire:click="confirmUnbanUser({{ $message->user->id }})" 
                                                        class="text-xs bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded transition text-green-600 flex items-center"
                                                        wire:loading.attr="disabled"
                                                    >
                                                        <i class="fas fa-check-circle mr-1"></i> {{ __('Yasağı Kaldır') }}
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty state for messages -->
                            <div class="text-center py-8 bg-white p-6 rounded-lg shadow-sm">
                                <i class="fas fa-comments text-gray-300 text-4xl mb-2"></i>
                                <p class="text-gray-500">{{ __('Bu başlıkta henüz mesaj bulunmamaktadır.') }}</p>
                                <p class="text-gray-500 text-sm mt-2">{{ __('İlk mesajı göndererek konuşmayı başlatabilirsiniz.') }}</p>
                            </div>
                        @endforelse
                        
                        <!-- Pagination with optimized loading -->
                        @if($messages instanceof \Illuminate\Pagination\LengthAwarePaginator && $messages->hasPages())
                            <div class="mt-6">
                                <div wire:loading.remove>
                                    {{ $messages->links() }}
                                </div>
                                <div wire:loading wire:target="gotoPage" class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin text-[#00c8b3] text-xl"></i>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Reply Form - optimized -->
                    @auth
                        <div id="replyForm" class="bg-white p-6 rounded-lg shadow-md mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Yanıt Yaz') }}</h3>
                            <form wire:submit.prevent="postMessage">
                                <div class="mb-4">
                                    <textarea 
                                        id="messageContent"
                                        wire:model.defer="messageContent" 
                                        rows="5" 
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00c8b3] focus:border-transparent transition"
                                        placeholder="{{ __('Düşüncelerinizi buraya yazın...') }}"
                                        dusk="message-content"
                                    ></textarea>
                                    @error('messageContent') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
                                </div>
                                <button 
                                    type="submit" 
                                    class="px-6 py-3 forum-btn rounded-md shadow-sm"
                                    dusk="post-message-button"
                                    wire:loading.attr="disabled"
                                >
                                    <span wire:loading.remove wire:target="postMessage">
                                        <i class="fas fa-paper-plane mr-2"></i> {{ __('Gönder') }}
                                    </span>
                                    <span wire:loading wire:target="postMessage">
                                        <i class="fas fa-spinner fa-spin mr-2"></i> {{ __('Gönderiliyor...') }}
                                    </span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-white p-6 rounded-lg shadow-md text-center mb-8">
                            <p class="text-gray-600 mb-4">{{ __('Yanıt yazabilmek için giriş yapmalısınız.') }}</p>
                            <a href="{{ route('login') }}" class="inline-block px-6 py-3 forum-btn rounded-md shadow-sm">
                                <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Giriş Yap') }}
                            </a>
                        </div>
                    @endauth
                @else
                    <!-- Topic list when no topic is selected -->
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            @if($selectedCategoryId)
                                <i class="fas fa-folder text-[#00c8b3] mr-2"></i>
                                {{ $categories->firstWhere('id', $selectedCategoryId)->name ?? __('Kategori') }}
                            @else
                                <i class="fas fa-list text-[#00c8b3] mr-2"></i>
                                {{ __('Tüm Başlıklar') }}
                            @endif
                            
                            @if($searchTerm)
                                <span class="ml-2 text-sm font-normal text-gray-500">
                                    "{{ $searchTerm }}" {{ __('için sonuçlar') }}
                                </span>
                            @endif
                        </h2>
                        
                        @if($selectedCategoryId)
                            <div class="text-sm">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                    {{ $topics->total() }} {{ __('başlık') }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div id="topics-container" class="topics-list-container">
                        @forelse($topics as $topic)
                            <div 
                                data-topic-id="{{ $topic->id }}" 
                                wire:key="topic-{{ $topic->id }}"
                                class="block border border-gray-200 rounded-lg p-3 mb-3 group {{ $topic->is_pinned ? 'bg-gradient-to-r from-[#00c8b3]/5 to-[#0099e5]/5' : 'bg-white' }} {{ $selectedTopicId == $topic->id ? 'ring-2 ring-[#00c8b3] shadow-md' : '' }} cursor-pointer"
                                dusk="topic-{{ $topic->id }}"
                                role="button"
                                tabindex="0"
                                aria-labelledby="topic-title-{{ $topic->id }}"
                                wire:click="selectTopic({{ $topic->id }})"
                            >
                                <div class="flex flex-col">
                                    <div class="flex-1">
                                        <div class="flex items-start flex-col justify-between">
                                            <h3 
                                                id="topic-title-{{ $topic->id }}"
                                                class="font-medium text-base text-gray-800 mb-1 pr-4 flex items-center"
                                            >
                                                @if($topic->is_pinned)
                                                    <i class="fas fa-thumbtack text-[#00c8b3] mr-2" title="{{ __('Sabitlenmiş Başlık') }}"></i>
                                                @endif
                                                <span class="hover:text-[#00c8b3] transition duration-150 ease-in-out">
                                                    {{ $topic->title }}
                                                </span>
                                                <i class="fas fa-chevron-right ml-2 text-[#00c8b3] text-xs opacity-40 group-hover:opacity-100 transition-opacity"></i>
                                            </h3>
                                            <div class="flex space-x-3 text-xs text-gray-500">
                                                <span class="bg-gray-50 px-2 py-1 rounded">
                                                    <i class="fas fa-comments mr-1"></i> {{ $topic->messages_count }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2 mt-2 text-sm">
                                            <span class="bg-gray-50 text-gray-600 px-2 py-0.5 rounded-full text-xs">
                                                <i class="fas fa-folder text-[#00c8b3] mr-1"></i> {{ $topic->category->name }}
                                            </span>
                                            <span class="bg-gray-50 text-gray-600 px-2 py-0.5 rounded-full text-xs">
                                                <i class="fas fa-user text-[#00c8b3] mr-1"></i> {{ $topic->user->name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($topic->lastMessage) && $topic->lastMessage)
                                    <div class="mt-2 pt-2 border-t border-gray-100">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs text-gray-500">{{ __('Son Yanıt:') }}</span>
                                            <span class="text-xs text-gray-500">{{ $topic->lastMessage->created_at->format('d.m.Y H:i') }}</span>
                                        </div>
                                        <div class="flex items-start space-x-2">
                                            <img 
                                                loading="lazy"
                                                src="{{ $topic->lastMessage->user->profile_photo_url }}" 
                                                alt="{{ $topic->lastMessage->user->name }}" 
                                                class="h-6 w-6 rounded-full flex-shrink-0 mt-0.5"
                                                onerror="this.onerror=null;this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCAzMCAzMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIGZpbGw9IiNDQ0NDQ0MiLz48cGF0aCBkPSJNMTUgMTVDMTcuNzYxNCAxNSAyMCAxMi43NjE0IDIwIDEwQzIwIDcuMjM4NTggMTcuNzYxNCA1IDE1IDVDMTIuMjM4NiA1IDEwIDcuMjM4NTggMTAgMTBDMTAgMTIuNzYxNCAxMi4yMzg2IDE1IDE1IDE1WiIgZmlsbD0id2hpdGUiLz48cGF0aCBkPSJNMjAgMThIMTBDNy43OTA4NiAxOCA2IDE5Ljc5MDkgNiAyMlYyNUg2LjVIMjMuNUgyNFYyMkMyNCAyMCAyMi4yMDkxIDE4IDIwIDE4WiIgZmlsbD0id2hpdGUiLz48L3N2Zz4=';"
                                            >
                                            <div class="flex-1 overflow-hidden">
                                                <div class="flex items-center space-x-1">
                                                    <span class="font-medium text-xs text-gray-700">{{ $topic->lastMessage->user->name }}:</span>
                                                </div>
                                                <p class="text-xs text-gray-600 truncate">{{ \Illuminate\Support\Str::limit(strip_tags($topic->lastMessage->content), 60) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-folder-open text-gray-300 text-4xl mb-2"></i>
                                <p class="text-gray-500">{{ __('Henüz başlık bulunmamaktadır.') }}</p>
                                <button 
                                    wire:click="openCreateTopicModal" 
                                    class="mt-3 px-4 py-2 forum-btn rounded-md shadow-sm"
                                >
                                    <i class="fas fa-plus-circle mr-2"></i> {{ __('İlk Başlığı Oluştur') }}
                                </button>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination and Load More Button -->
                    @if(method_exists($topics, 'hasPages') && $topics->hasPages())
                        <div class="mt-6">
                            {{ $topics->links() }}
                        </div>
                    @endif
                    
                    @if($isLazyLoading && $topics->count() >= 10)
                        <div class="text-center mt-4">
                            <button 
                                wire:click="loadMoreTopics"
                                wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 transition rounded-md shadow-sm"
                            >
                                <span wire:loading.remove wire:target="loadMoreTopics">{{ __('Daha Fazla Yükle') }}</span>
                                <span wire:loading wire:target="loadMoreTopics">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> {{ __('Yükleniyor...') }}
                                </span>
                            </button>
                        </div>
                    @endif
                    
                    <!-- Latest Activity -->
                    <div class="mt-6" wire:init="loadDeferredContent">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-history mr-2 text-[#00c8b3]"></i>
                            {{ __('Son Aktiviteler') }}
                        </h3>
                        
                        <div class="space-y-4">
                            @if(empty($latestActivities) || count($latestActivities) === 0)
                                <div class="text-center py-8">
                                    <div class="animate-pulse flex space-y-3 flex-col items-center justify-center">
                                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                        <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                                    </div>
                                </div>
                            @else
                                @forelse($latestActivities as $activity)
                                    <div class="border-l-2 border-[#00c8b3] pl-3 py-1">
                                        <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                                        <div class="text-sm mt-1">
                                            @if($activity->type === 'topic_created')
                                                <span class="font-medium">{{ $activity->user->name }}</span> 
                                                {{ __('yeni bir başlık oluşturdu:') }} 
                                                <a href="{{ route('forum.category.topic.show', ['category' => $activity->category_id, 'topic' => $activity->topic_id]) }}" 
                                                   class="text-[#00c8b3] hover:underline"
                                                >{{ \Illuminate\Support\Str::limit($activity->title, 30) }}</a>
                                            @elseif($activity->type === 'message_posted')
                                                <span class="font-medium">{{ $activity->user->name }}</span> 
                                                {{ __('bir mesaj gönderdi:') }}
                                                <a href="{{ route('forum.category.topic.show', ['category' => $activity->category_id, 'topic' => $activity->topic_id]) }}" 
                                                   class="text-[#00c8b3] hover:underline"
                                                >{{ \Illuminate\Support\Str::limit($activity->title, 30) }}</a>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-500">
                                        <i class="fas fa-history text-gray-300 text-2xl mb-2"></i>
                                        <p>{{ __('Henüz aktivite bulunmamaktadır.') }}</p>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Topic Content -->
        <div class="forum-right-column">
            <!-- Column Header -->
            <div class="forum-column-header mb-4 w-full">
                <h2 class="text-lg font-bold text-white bg-gradient-to-r from-[#00c8b3] to-[#0099e5] py-3 px-4 rounded-lg shadow-sm flex items-center w-full">
                    <i class="fas fa-newspaper mr-2 text-white"></i>
                    {{ __('Hekimport Duyuruları') }}
                </h2>
            </div>
            
            <!-- Hekimport Duyuruları (News Section) -->
            <div class="space-y-6" wire:init="loadDeferredContent">
                @if(empty($recentNews) || count($recentNews) === 0)
                <!-- Loading state for news -->
                <div class="text-center py-8">
                    <div class="animate-pulse flex space-y-6 flex-col items-center justify-center">
                        <div class="h-5 bg-gray-200 rounded w-3/4"></div>
                        <div class="h-32 bg-gray-100 rounded w-full"></div>
                        <div class="h-5 bg-gray-200 rounded w-1/2"></div>
                        <div class="h-32 bg-gray-100 rounded w-full"></div>
                    </div>
                </div>
                @else
                <!-- Loaded news content -->
                <div>
                    @forelse($recentNews as $news)
                    <!-- News Item -->
                    <div class="news-item">
                        @if($news['is_new'])
                        <span class="news-badge bg-gradient-to-r from-[#00c8b3] to-[#0099e5] text-white">
                            Yeni
                        </span>
                        @endif
                        <h3>{{ $news['title'] }}</h3>
                        <div class="news-item-meta">
                            <span class="news-item-date">
                                <i class="fas fa-calendar-alt text-[#00c8b3] mr-1"></i>
                                {{ $news['date'] }}
                            </span>
                            <span class="news-item-author">
                                <i class="fas fa-user text-[#00c8b3] mr-1"></i>
                                {{ $news['author'] }}
                            </span>
                        </div>
                        <div class="news-item-content">
                            <p>{{ $news['content'] }}</p>
                            <div class="mt-2 flex justify-end">
                                <a href="#" class="text-xs text-[#0099e5] hover:underline flex items-center">
                                    <span>Detaylar</span>
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-newspaper text-gray-300 text-2xl mb-2"></i>
                        <p>{{ __('Henüz duyuru bulunmamaktadır.') }}</p>
                    </div>
                    @endforelse
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals and Confirmation Popups -->
    @include('livewire.forum.modals')
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('forumContent', () => ({
        isLoading: false,
        init() {
            // Listen for loading events from Livewire
            Livewire.on('loading', () => { this.isLoading = true });
            Livewire.on('loaded', () => { this.isLoading = false });
            Livewire.on('deferredContentLoaded', () => { console.log('Deferred content loaded'); });
        }
    }));
});
</script>
