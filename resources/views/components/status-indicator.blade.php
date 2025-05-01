@props(['status'])

@php
    $config = [
        'en_attente' => ['label' => 'En attente', 'color' => 'yellow'],
        'en_revue' => ['label' => 'En revue', 'color' => 'blue'],
        'entretien' => ['label' => 'Entretien', 'color' => 'indigo'],
        'accepte' => ['label' => 'Accepté', 'color' => 'green'],
        'rejete' => ['label' => 'Rejeté', 'color' => 'red'],
        'approuve' => ['label' => 'Approuvé', 'color' => 'green'],
        'rejete' => ['label' => 'Rejeté', 'color' => 'red'],
    ];
    
    $statusConfig = $config[$status] ?? ['label' => $status, 'color' => 'gray'];
@endphp

<x-badge :color="$statusConfig['color']">
    {{ $statusConfig['label'] }}
</x-badge>