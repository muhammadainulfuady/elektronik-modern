@props(['for' => null])

<label {{ $for ? "for=$for" : '' }} {{ $attributes->merge(['class' => 'block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-2']) }}>
    {{ $slot }}
</label>
