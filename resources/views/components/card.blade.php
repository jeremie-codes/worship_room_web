@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md p-6 ' . $class]) }}>
    {{ $slot }}
</div>