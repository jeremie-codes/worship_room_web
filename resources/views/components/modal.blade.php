@props(['id', 'title'])

<div id="{{ $id }}" class="fixed inset-0 hidden z-50 overflow-y-auto overflow-x-hidden" aria-modal="true" role="dialog">
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="document.getElementById('{{ $id }}').classList.remove('flex'); document.getElementById('{{ $id }}').classList.add('hidden')"></div>
        
        <!-- Modal content -->
        <div class="bg-white rounded-lg shadow-xl z-10 w-full max-w-md md:max-w-lg lg:max-w-xl relative transform transition-all">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="document.getElementById('{{ $id }}').classList.remove('flex'); document.getElementById('{{ $id }}').classList.add('hidden')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>