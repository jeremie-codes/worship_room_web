@props(['class' => ''])

<td {{ $attributes->merge(['class' => 'px-6 py-4 whitespace-nowrap ' . $class]) }}>
    {{ $slot }}
</td>