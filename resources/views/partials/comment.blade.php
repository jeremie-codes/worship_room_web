<div class="flex gap-3 py-3">
    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center flex-shrink-0">
        @if($comment->user->avatar)
            <img src="{{ Storage::url($comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="w-full h-full rounded-full object-cover">
        @else
            <i class='bx bx-user text-white text-sm'></i>
        @endif
    </div>
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-1">
            <span class="text-white font-medium text-sm">{{ $comment->user->name }}</span>
            <span class="text-gray-500 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
            @if($comment->is_highlighted)
                <span class="bg-accent-500 text-white px-2 py-1 rounded text-xs font-semibold">
                    ÉPINGLÉ
                </span>
            @endif
        </div>
        <p class="text-gray-300 text-sm leading-relaxed">{{ $comment->content }}</p>
        
        @auth
            <div class="flex items-center gap-4 mt-2">
                <button class="text-gray-400 hover:text-white text-xs transition-colors">
                    <i class='bx bx-like mr-1'></i>J'aime
                </button>
                <button class="text-gray-400 hover:text-white text-xs transition-colors">
                    <i class='bx bx-message mr-1'></i>Répondre
                </button>
                @if(auth()->user()->id === $comment->user_id)
                    <button class="text-gray-400 hover:text-red-400 text-xs transition-colors">
                        <i class='bx bx-trash mr-1'></i>Supprimer
                    </button>
                @endif
            </div>
        @endauth
    </div>
</div>