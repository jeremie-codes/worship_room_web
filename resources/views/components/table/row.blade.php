@props(['class' => ''])

<tr {{ $attributes->merge(['class' => 'hover:bg-gray-50 ' . $class]) }}>
    {{ $slot }}
</tr>