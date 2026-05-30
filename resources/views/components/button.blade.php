@props(['variant' => 'primary'])

@php
    $classes = 'py-3.5 px-5 rounded-xl font-bold text-[15px] transition-all flex items-center justify-center gap-2 ';
    $classes .= match($variant) {
        'primary' => 'bg-primary text-white shadow-[0_4px_12px_rgba(26,92,255,0.3)] hover:bg-primary-dark hover:-translate-y-px hover:shadow-[0_6px_20px_rgba(26,92,255,0.4)]',
        'secondary' => 'bg-g100 text-g700 hover:bg-g200',
        'danger' => 'bg-danger text-white shadow-[0_4px_12px_rgba(220,38,38,0.3)] hover:bg-danger/90 hover:-translate-y-px',
        'outline' => 'bg-transparent border border-g200 text-g700 hover:bg-g50',
        default => 'bg-primary text-white',
    };
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
