<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Administrativo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Estatísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total de Empresas</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $stats['total_companies'] }}</div>
                    <div class="text-green-600 text-sm mt-1">{{ $stats['active_companies'] }} ativas</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total de Avaliações</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $stats['total_reviews'] }}</div>
                    <div class="text-sm mt-1">
                        <span class="text-green-600">{{ $stats['total_positive'] }} positivas</span> / 
                        <span class="text-red-600">{{ $stats['total_negative'] }} negativas</span>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Média Geral</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $stats['average_rating'] }}</div>
                    <div class="text-yellow-500 text-xl mt-1">
                        {{ str_repeat('⭐', round($stats['average_rating'])) }}
                    </div>
                </div>
            </div>

            {{-- Alertas de Avaliações Negativas --}}
            @if($negative_alerts->count() > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex items-center mb-2">
                    <span class="text-2xl mr-2">🚨</span>
                    <h3 class="font-bold text-red-800">Avaliações Negativas Recentes (últimas 24h)</h3>
                </div>
                <div class="space-y-2">
                    @foreach($negative_alerts as $alert)
                    <div class="bg-white p-3 rounded flex justify-between items-center">
                        <div>
                            <span class="font-semibold">{{ $alert->company->name }}</span>
                            <span class="text-sm text-gray-600">- {{ $alert->rating }} ⭐</span>
                            <span class="text-sm text-gray-500">| {{ $alert->whatsapp }}</span>
                        </div>
                        <a href="https://wa.me/{{ $alert->formatted_whatsapp }}" 
                           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" 
                           target="_blank">
                            Contatar
                        </a>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.reviews.negatives') }}" class="text-red-700 font-semibold mt-3 inline-block">
                    Ver todas as avaliações negativas →
                </a>
            </div>
            @endif

            {{-- Gráfico de Avaliações (últimos 7 dias) --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
                <h3 class="font-bold text-lg mb-4">Avaliações dos Últimos 7 Dias</h3>
                <div class="space-y-2">
                    @foreach($reviews_chart as $day)
                    <div class="flex items-center">
                        <div class="w-32 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($day->date)->format('d/m') }}
                        </div>
                        <div class="flex-1 flex gap-1">
                            <div class="bg-green-500 h-8 flex items-center justify-center text-white text-xs font-bold" 
                                 style="width: {{ ($day->positive / max($reviews_chart->max('total'), 1)) * 100 }}%">
                                {{ $day->positive > 0 ? $day->positive : '' }}
                            </div>
                            <div class="bg-red-500 h-8 flex items-center justify-center text-white text-xs font-bold" 
                                 style="width: {{ ($day->negative / max($reviews_chart->max('total'), 1)) * 100 }}%">
                                {{ $day->negative > 0 ? $day->negative : '' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Top 5 Empresas --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
                <h3 class="font-bold text-lg mb-4">Top 5 Empresas por Avaliações</h3>
                <div class="space-y-3">
                    @foreach($top_companies as $company)
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <a href="{{ route('admin.companies.show', $company) }}" class="font-semibold hover:text-blue-600">
                                {{ $company->name }}
                            </a>
                            <span class="text-sm text-gray-500 ml-2">({{ $company->reviews_count }} avaliações)</span>
                        </div>
                        <a href="{{ route('admin.companies.show', $company) }}" class="text-blue-600 hover:underline">
                            Ver detalhes
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Últimas Avaliações --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="font-bold text-lg mb-4">Últimas 10 Avaliações</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Empresa</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nota</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recent_reviews as $review)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $review->company->name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $review->rating_stars }}</td>
                                <td class="px-4 py-3 text-sm">{{ $review->whatsapp }}</td>
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
            </div>

        </div>
    </div>
</x-app-layout>





