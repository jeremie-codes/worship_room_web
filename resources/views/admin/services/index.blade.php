@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Services</h1>
        <a href="{{ route('services.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouveau Service
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Parent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agents</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sous-services</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($services as $service)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->serviceParent?->nom ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->responsable?->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->agents_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->sous_services_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('services.edit', $service) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Modifier
                        </a>
                        @if($service->agents_count === 0 && $service->sous_services_count === 0)
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                                    Supprimer
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
