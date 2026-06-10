@props(['type' => 'info']) 

@php
    $classes = 'py-3 px-4 rounded-xl text-[13px] font-bold border ';
    $classes .= match($type) {
        'success' => 'bg-green-50 text-green-700 border-green-200',
        'danger' => 'bg-red-50 text-red-700 border-red-200',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        default => 'bg-blue-50 text-blue-700 border-blue-200',
    };
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    {{ $slot }}
</div>
