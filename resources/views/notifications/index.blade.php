@extends('layouts.app')

@section('title', 'Notifications - Worship Room')
@section('page-title', 'Notifications')
@section('page-subtitle', 'Restez informé de l\'activité de votre communauté')

@section('content')
<div class="space-y-6">
    <!-- Actions Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button onclick="markAllAsRead()" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition-colors">
                <i class='bx bx-check-double mr-2'></i>Tout Marquer comme Lu
            </button>
            <div class="text-sm text-gray-400">
                {{ $notifications->where('is_read', false)->count() }} notification(s) non lue(s)
            </div>
        </div>
        
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                <i class='bx bx-filter mr-2'></i>Filtrer
            </button>
            <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                <i class='bx bx-cog mr-2'></i>Paramètres
            </button>
        </div>
    </div>

    @if($notifications->count() > 0)
        <!-- Notifications List -->
        <div class="bg-gray-800 rounded-xl overflow-hidden">
            @foreach($notifications as $notification)
                <div class="notification-item border-b border-gray-700 last:border-b-0 {{ $notification->is_read ? 'bg-gray-800' : 'bg-gray-700/30' }} hover:bg-gray-700/50 transition-colors">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <!-- Notification Icon -->
                            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0
                                @if($notification->type === 'stream_started') bg-red-500/20 text-red-400
                                @elseif($notification->type === 'new_subscriber') bg-blue-500/20 text-blue-400
                                @elseif($notification->type === 'donation_received') bg-green-500/20 text-green-400
                                @elseif($notification->type === 'video_published') bg-purple-500/20 text-purple-400
                                @else bg-gray-500/20 text-gray-400 @endif">
                                @if($notification->type === 'stream_started')
                                    <i class='bx bx-broadcast text-xl'></i>
                                @elseif($notification->type === 'new_subscriber')
                                    <i class='bx bx-heart text-xl'></i>
                                @elseif($notification->type === 'donation_received')
                                    <i class='bx bx-dollar text-xl'></i>
                                @elseif($notification->type === 'video_published')
                                    <i class='bx bx-video text-xl'></i>
                                @else
                                    <i class='bx bx-bell text-xl'></i>
                                @endif
                            </div>
                            
                            <!-- Notification Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-white font-semibold mb-1">{{ $notification->title }}</h3>
                                        <p class="text-gray-300 text-sm mb-2">{{ $notification->message }}</p>
                                        <div class="flex items-center gap-4 text-xs text-gray-400">
                                            <span><i class='bx bx-time mr-1'></i>{{ $notification->created_at->diffForHumans() }}</span>
                                            @if($notification->type === 'stream_started')
                                                <span class="text-red-400"><i class='bx bx-broadcast mr-1'></i>Live</span>
                                            @elseif($notification->type === 'new_subscriber')
                                                <span class="text-blue-400"><i class='bx bx-heart mr-1'></i>Abonnement</span>
                                            @elseif($notification->type === 'donation_received')
                                                <span class="text-green-400"><i class='bx bx-dollar mr-1'></i>Don</span>
                                            @elseif($notification->type === 'video_published')
                                                <span class="text-purple-400"><i class='bx bx-video mr-1'></i>Vidéo</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center gap-2 ml-4">
                                        @if(!$notification->is_read)
                                            <button onclick="markAsRead({{ $notification->id }})" 
                                                    class="p-2 text-gray-400 hover:text-primary-400 transition-colors" 
                                                    title="Marquer comme lu">
                                                <i class='bx bx-check'></i>
                                            </button>
                                        @endif
                                        
                                        @if($notification->type === 'stream_started' && isset($notification->data['stream_id']))
                                            <a href="{{ route('streams.show', $notification->data['stream_id']) }}" 
                                               class="px-3 py-1 bg-primary-500 hover:bg-primary-600 text-white rounded text-xs font-semibold transition-colors">
                                                Regarder
                                            </a>
                                        @elseif($notification->type === 'video_published' && isset($notification->data['video_id']))
                                            <a href="{{ route('videos.show', $notification->data['video_id']) }}" 
                                               class="px-3 py-1 bg-primary-500 hover:bg-primary-600 text-white rounded text-xs font-semibold transition-colors">
                                                Voir
                                            </a>
                                        @elseif($notification->type === 'donation_received')
                                            <a href="{{ route('broadcaster.donations') }}" 
                                               class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-semibold transition-colors">
                                                Voir Don
                                            </a>
                                        @endif
                                        
                                        <button class="p-2 text-gray-400 hover:text-red-400 transition-colors" title="Supprimer">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </div>
                                
                                @if(!$notification->is_read)
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary-500"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-bell text-gray-400 text-4xl'></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Aucune Notification</h3>
            <p class="text-gray-400 mb-6">Vous êtes à jour ! Aucune nouvelle notification pour le moment.</p>
            <a href="{{ route('dashboard') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class='bx bx-home mr-2'></i>Retour au Tableau de Bord
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    async function markAsRead(notificationId) {
        try {
            const response = await fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) {
                // Update UI to show as read
                const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.classList.remove('bg-gray-700/30');
                    notificationElement.classList.add('bg-gray-800');
                    
                    // Remove the unread indicator
                    const indicator = notificationElement.querySelector('.bg-primary-500');
                    if (indicator) {
                        indicator.remove();
                    }
                    
                    // Remove the mark as read button
                    const markButton = notificationElement.querySelector('button[onclick*="markAsRead"]');
                    if (markButton) {
                        markButton.remove();
                    }
                }
                
                // Update notification count
                loadNotificationCount();
                showToast('Notification marquée comme lue', 'success');
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
            showToast('Erreur lors de la mise à jour', 'error');
        }
    }

    async function markAllAsRead() {
        try {
            const response = await fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) {
                // Reload the page to show updated state
                window.location.reload();
            }
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
            showToast('Erreur lors de la mise à jour', 'error');
        }
    }
</script>
@endpush
@endsection