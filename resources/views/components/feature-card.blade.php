@props([
    'icon' => '',
    'title' => '',
    'colorClass' => 'text-primary-500' // Default color
])

<div {{ $attributes->merge(['class' => 'bg-white p-8 rounded-xl shadow-md transform transition duration-300 hover:scale-105 border border-gray-100']) }}>
    @if($icon)
    <div class="text-4xl mb-5 {{ $colorClass }}">{{ $icon }}</div>
    @endif
    <h3 class="text-xl md:text-2xl font-semibold mb-3 font-heading">{{ $title }}</h3>
    <p class="text-gray-600 leading-relaxed text-sm">
        {{ $slot }} {{-- Content goes here --}}
    </p>
</div> 