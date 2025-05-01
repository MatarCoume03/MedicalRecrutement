@props(['type'])

@php
    $icons = [
        'cv' => 'document-text',
        'lettre_motivation' => 'envelope',
        'diplome' => 'academic-cap',
        'certificat' => 'badge-check',
        'autre' => 'document'
    ];
    
    $icon = $icons[$type] ?? 'document';
    $color = match($type) {
        'cv' => 'text-blue-500',
        'lettre_motivation' => 'text-indigo-500',
        'diplome' => 'text-amber-500',
        'certificat' => 'text-emerald-500',
        default => 'text-gray-500'
    };
@endphp

<x-dynamic-component :component="'icons.' . $icon" class="h-8 w-8 {{ $color }}" />