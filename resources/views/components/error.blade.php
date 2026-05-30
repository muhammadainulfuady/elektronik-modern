@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[12px] text-danger font-bold mt-1.5']) }}>
        @foreach ((array) $messages as $message)
            <li><i class="fi fi-rr-info mr-1"></i> {{ $message }}</li>
        @endforeach
    </ul>
@endif
