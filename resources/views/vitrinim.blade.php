<x-app-layout> {{-- Use your project's main authenticated layout --}}
    <x-slot name="header">
        {{-- Optionally hide default header or customize --}}
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vitrinim') }}
        </h2> --}}
    </x-slot>

    {{-- Add specific meta tags if needed --}}
    @section('meta')
        <meta name="title" content="Hekimport - Vitrinim Yönetimi">
        <meta name="description" content="Hekimport Vitrinim paneli ile dijital görünürlüğünüzü ve hasta etkileşimlerinizi yönetin.">
        <meta name="keywords" content="hekimport, vitrinim, diş hekimi paneli, vitrin yönetimi, analitik">
    @endsection

    <div class="py-6 sm:py-12"> {{-- Adjust padding as needed --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Include the Livewire component that manages the tabs --}}
            @livewire('vitrinim-page')
        </div>
    </div>
</x-app-layout> 