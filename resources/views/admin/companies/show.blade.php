<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $company->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.companies.edit', $company) }}" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Editar
                </a>
                <a href="{{ $company->reviewPage->public_url }}" 
                   target="_blank"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Ver Página Pública
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Estatísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total de Avaliações</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $statistics['total_reviews'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Avaliações Positivas</div>
                    <div class="text-3xl font-bold text-green-600">{{ $statistics['positive_reviews'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Avaliações Negativas</div>
                    <div class="text-3xl font-bold text-red-600">{{ $statistics['negative_reviews'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Média de Avaliação</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $statistics['average_rating'] }}</div>
                    <div class="text-yellow-500 text-xl mt-1">
                        {{ str_repeat('⭐', round($statistics['average_rating'])) }}
                    </div>
                </div>
            </div>

            {{-- Informações da Empresa --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
                <h3 class="font-bold text-lg mb-4">Informações da Empresa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $company->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-mail</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $company->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">URL do Google Reviews</label>
                        <a href="{{ $company->google_review_url }}" target="_blank" 
                           class="mt-1 text-sm text-blue-600 hover:underline">
                            {{ $company->google_review_url }}
                        </a>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Limite de Avaliação Positiva</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $company->positive_threshold }} estrelas</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        @if($company->is_active)
                            <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Ativa
                            </span>
                        @else
                            <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Inativa
                            </span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">URL Pública</label>
                        <a href="{{ $company->reviewPage->public_url }}" target="_blank" 
                           class="mt-1 text-sm text-blue-600 hover:underline">
                            {{ $company->reviewPage->public_url }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Imagens --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
                <h3 class="font-bold text-lg mb-4">Imagens</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                        @if($company->logo_url)
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" 
                                 class="h-32 w-32 object-contain border rounded">
                        @else
                            <div class="h-32 w-32 bg-gray-200 border rounded flex items-center justify-center">
                                <span class="text-gray-500">Sem logo</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagem de Fundo</label>
                        @if($company->background_image_url)
                            <img src="{{ $company->background_image_url }}" alt="{{ $company->name }}" 
                                 class="h-32 w-full object-cover border rounded">
                        @else
                            <div class="h-32 w-full bg-gray-200 border rounded flex items-center justify-center">
                                <span class="text-gray-500">Sem imagem de fundo</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Últimas Avaliações --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Últimas Avaliações</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.reviews.export-csv', $company) }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                            Exportar CSV
                        </a>
                        <a href="{{ route('admin.reviews.export', $company) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                            Exportar Excel
                        </a>
                    </div>
                </div>
                
                @if($company->reviews->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nota</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Comentário</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($company->reviews as $review)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $review->rating_stars }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $review->whatsapp }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $review->comment ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($review->is_positive)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Positiva</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Negativa</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        Nenhuma avaliação recebida ainda.
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>





