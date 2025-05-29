@props(['type' => 'button', 'class' => ''])

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ' . $class]) }}
>
    {{ $slot }}
</button>