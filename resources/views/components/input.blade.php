@props(['disabled' => false, 'error' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full py-3.5 px-4 border-[1.5px] ' . ($error ? 'border-danger bg-danger-light/20' : 'border-g200 bg-g50') . ' rounded-xl outline-none text-sm font-semibold text-g800 transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 disabled:opacity-50 disabled:cursor-not-allowed']) !!}>
