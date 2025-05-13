@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false
])

@php
$variantClasses = [
    'primary' => 'bg-gradient-to-r from-teal-500 to-blue-500 hover:from-teal-600 hover:to-blue-600 text-white focus:ring-blue-500',
    'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-500',
    'success' => 'bg-green-500 hover:bg-green-600 text-white focus:ring-green-500',
    'danger' => 'bg-red-500 hover:bg-red-600 text-white focus:ring-red-500',
    'warning' => 'bg-amber-500 hover:bg-amber-600 text-white focus:ring-amber-500',
    'info' => 'bg-blue-500 hover:bg-blue-600 text-white focus:ring-blue-500',
];

$sizeClasses = [
    'sm' => 'px-2.5 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-5 py-2.5 text-base',
    'xl' => 'px-6 py-3 text-base',
];

$commonClasses = 'inline-flex items-center justify-center border border-transparent rounded-md font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 ease-in-out';
@endphp

<button 
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $commonClasses . ' ' . $sizeClasses[$size] . ' ' . $variantClasses[$variant]]) }}
>
    {{ $slot }}
</button> 