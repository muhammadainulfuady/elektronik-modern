@props(['variant' => 'primary'])

@php
    $classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold ';
    $classes .= match($variant) {
        'primary' => 'bg-primary-light text-primary',
        'success' => 'bg-success-light text-success',
        'danger' => 'bg-danger-light text-danger',
        'warn' => 'bg-warn-light text-warn',
        'pending' => 'bg-pend-light text-pend',
        'g700' => 'bg-g100 text-g700',
        default => 'bg-g100 text-g600',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
