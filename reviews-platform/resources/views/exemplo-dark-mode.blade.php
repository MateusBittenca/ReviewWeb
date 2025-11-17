@extends('layouts.admin')

@section('title', 'Exemplo - Dark Mode')

@section('page-title', 'Exemplo de Dark Mode')
@section('page-description', 'Demonstração completa de componentes com suporte a modo escuro')

@section('header-actions')
    <button class="btn-primary text-white px-4 py-2 rounded-lg font-medium">
        <i class="fas fa-plus mr-2"></i>
        Nova Ação
    </button>
@endsection

@section('content')
    <!-- Grid de Cards Exemplo -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Estatística -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 icon-gradient rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <span class="text-sm font-medium text-green-600 dark:text-green-400">+12%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-1">1,234</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Total de Usuários</p>
        </div>

        <!-- Card 2: Ação -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 card-hover">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-star text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">Avaliações</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">342 este mês</p>
                </div>
            </div>
            <button class="w-full btn-primary text-white px-4 py-2 rounded-lg font-medium">
                Ver Todas
            </button>
        </div>

        <!-- Card 3: Lista -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 card-hover">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">Atividades Recentes</h3>
            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    <span class="text-gray-700 dark:text-gray-300">Nova avaliação</span>
                </div>
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                    <span class="text-gray-700 dark:text-gray-300">Empresa criada</span>
                </div>
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                    <span class="text-gray-700 dark:text-gray-300">Feedback recebido</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulário Exemplo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Formulário de Exemplo</h2>
        
        <form class="space-y-6">
            <!-- Nome -->
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nome Completo
                </label>
                <input 
                    type="text" 
                    id="nome"
                    class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="Digite seu nome..."
                >
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Email
                </label>
                <input 
                    type="email" 
                    id="email"
                    class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="seu@email.com"
                >
            </div>

            <!-- Select -->
            <div>
                <label for="categoria" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Categoria
                </label>
                <select 
                    id="categoria"
                    class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                    <option>Selecione uma opção</option>
                    <option>Opção 1</option>
                    <option>Opção 2</option>
                    <option>Opção 3</option>
                </select>
            </div>

            <!-- Textarea -->
            <div>
                <label for="mensagem" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Mensagem
                </label>
                <textarea 
                    id="mensagem"
                    rows="4"
                    class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                    placeholder="Digite sua mensagem..."
                ></textarea>
            </div>

            <!-- Checkbox -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="termos"
                    class="w-4 h-4 text-purple-600 border-gray-300 dark:border-gray-600 rounded focus:ring-purple-500"
                >
                <label for="termos" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                    Aceito os termos e condições
                </label>
            </div>

            <!-- Botões -->
            <div class="flex items-center space-x-3">
                <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Salvar
                </button>
                <button type="button" class="btn-secondary text-white px-6 py-2 rounded-lg font-medium">
                    Cancelar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabela Exemplo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Tabela de Dados</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Nome</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Data</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">#001</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">Exemplo 1</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                Ativo
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">24/10/2024</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">#002</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">Exemplo 2</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                Pendente
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">23/10/2024</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">#003</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">Exemplo 3</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                Inativo
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">22/10/2024</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alertas Exemplo -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Alerta Sucesso -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="font-medium">Operação realizada com sucesso!</span>
            </div>
        </div>

        <!-- Alerta Erro -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">Erro ao processar a requisição.</span>
            </div>
        </div>

        <!-- Alerta Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                <span class="font-medium">Informação importante para o usuário.</span>
            </div>
        </div>

        <!-- Alerta Warning -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-300 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span class="font-medium">Atenção! Verifique os dados.</span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Exemplo de JavaScript que funciona com dark mode
        console.log('Modo atual:', document.documentElement.classList.contains('dark') ? 'Escuro' : 'Claro');
        
        // Observar mudanças no modo
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isDark = document.documentElement.classList.contains('dark');
                    console.log('Modo alterado para:', isDark ? 'Escuro' : 'Claro');
                }
            });
        });
        
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>
@endsection

