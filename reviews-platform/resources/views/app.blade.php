<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Platform - Sistema de Avaliações</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
        /* Tailwind CSS Base Styles */
        *, ::before, ::after {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb;
        }
        
        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            tab-size: 4;
        }
        
        body {
            margin: 0;
            line-height: inherit;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
        }
        
        /* Utility Classes */
        .min-h-screen { min-height: 100vh; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-white { background-color: #ffffff; }
        .bg-blue-50 { background-color: #eff6ff; }
        .bg-green-50 { background-color: #f0fdf4; }
        .bg-red-50 { background-color: #fef2f2; }
        .bg-gray-50 { background-color: #f9fafb; }
        
        .text-gray-900 { color: #111827; }
        .text-gray-700 { color: #374151; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-500 { color: #6b7280; }
        .text-blue-900 { color: #1e3a8a; }
        .text-blue-700 { color: #1d4ed8; }
        .text-green-900 { color: #14532d; }
        .text-green-700 { color: #15803d; }
        .text-red-900 { color: #7f1d1d; }
        .text-red-700 { color: #b91c1c; }
        .text-red-800 { color: #991b1b; }
        .text-orange-700 { color: #c2410c; }
        .text-white { color: #ffffff; }
        
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .font-medium { font-weight: 500; }
        
        .shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); }
        .shadow { box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); }
        
        .border { border-width: 1px; }
        .border-b { border-bottom-width: 1px; }
        .border-t { border-top-width: 1px; }
        .border-b-2 { border-bottom-width: 2px; }
        .border-gray-200 { border-color: #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
        .border-red-200 { border-color: #fecaca; }
        
        .rounded { border-radius: 0.25rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .px-1 { padding-left: 0.25rem; padding-right: 0.25rem; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-12 { margin-top: 3rem; }
        .ml-2 { margin-left: 0.5rem; }
        .mr-3 { margin-right: 0.75rem; }
        
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .space-x-2 > * + * { margin-left: 0.5rem; }
        .space-x-3 > * + * { margin-left: 0.75rem; }
        .space-x-4 > * + * { margin-left: 1rem; }
        .space-x-8 > * + * { margin-left: 2rem; }
        
        .flex { display: flex; }
        .grid { display: grid; }
        .hidden { display: none; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        
        .max-w-7xl { max-width: 80rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        
        .h-16 { height: 4rem; }
        
        .w-full { width: 100%; }
        .w-16 { width: 4rem; }
        
        /* Button Styles */
        .bg-blue-600 { background-color: #2563eb; }
        .bg-green-600 { background-color: #16a34a; }
        .bg-red-600 { background-color: #dc2626; }
        .bg-gray-300 { background-color: #d1d5db; }
        .bg-gray-600 { background-color: #4b5563; }
        .bg-red-100 { background-color: #fee2e2; }
        
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:bg-green-700:hover { background-color: #15803d; }
        .hover\:bg-red-700:hover { background-color: #b91c1c; }
        .hover\:bg-gray-400:hover { background-color: #9ca3af; }
        .hover\:bg-gray-700:hover { background-color: #374151; }
        .hover\:text-gray-700:hover { color: #374151; }
        .hover\:border-gray-300:hover { border-color: #d1d5db; }
        
        .border-blue-500 { border-color: #3b82f6; }
        .text-blue-600 { color: #2563eb; }
        .border-transparent { border-color: transparent; }
        
        /* Input Styles */
        input, select, textarea {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgb(59 130 246 / 0.1);
        }
        
        /* Responsive */
        @media (min-width: 768px) {
            .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
            .md\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        }
        
        @media (min-width: 1024px) {
            .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        }
        
        @media (min-width: 640px) {
            .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        }
    </style>
</head>
<body>
    <div id="root"></div>
    
    <script type="text/babel">
        const { useState } = React;
        
        const App = () => {
            const [currentPage, setCurrentPage] = useState('dashboard');
            const [message, setMessage] = useState('Reviews Platform funcionando!');
            
            const pages = {
                dashboard: {
                    title: '🏠 Dashboard',
                    content: (
                        <div className="space-y-6">
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div className="bg-blue-50 p-6 rounded-lg">
                                    <h3 className="text-xl font-semibold text-blue-900 mb-2">🏢 Empresas</h3>
                                    <p className="text-blue-700 mb-2">Total: 24 empresas</p>
                                    <button onClick={() => setCurrentPage('companies')} className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                        Gerenciar Empresas
                                    </button>
                                </div>
                                
                                <div className="bg-green-50 p-6 rounded-lg">
                                    <h3 className="text-xl font-semibold text-green-900 mb-2">💬 Avaliações</h3>
                                    <p className="text-green-700 mb-2">Total: 342 avaliações</p>
                                    <button onClick={() => setCurrentPage('reviews')} className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                        Ver Avaliações
                                    </button>
                                </div>
                                
                                <div className="bg-red-50 p-6 rounded-lg">
                                    <h3 className="text-xl font-semibold text-red-900 mb-2">⚠️ Negativas</h3>
                                    <p className="text-red-700 mb-2">18 precisam atenção</p>
                                    <button onClick={() => setCurrentPage('negatives')} className="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                        Ver Negativas
                                    </button>
                                </div>
                            </div>
                            
                            <div className="bg-white p-6 rounded-lg shadow">
                                <h3 className="text-lg font-semibold mb-4">Avaliações Recentes</h3>
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <span className="font-medium">Restaurante XYZ</span>
                                            <span className="ml-2">⭐⭐⭐⭐⭐</span>
                                        </div>
                                        <span className="text-sm text-gray-500">Hoje 14:30</span>
                                    </div>
                                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <span className="font-medium">Loja ABC</span>
                                            <span className="ml-2">⭐⭐</span>
                                        </div>
                                        <span className="text-sm text-gray-500">Hoje 13:15</span>
                                    </div>
                                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <span className="font-medium">Café 123</span>
                                            <span className="ml-2">⭐⭐⭐⭐</span>
                                        </div>
                                        <span className="text-sm text-gray-500">Hoje 12:45</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )
                },
                companies: {
                    title: '🏢 Empresas',
                    content: (
                        <div className="space-y-6">
                            <div className="bg-white p-6 rounded-lg shadow">
                                <h3 className="text-lg font-semibold mb-4">Nova Empresa</h3>
                                <form className="space-y-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Nome da Empresa</label>
                                        <input type="text" className="w-full" placeholder="Ex: Restaurante XYZ" />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" className="w-full" placeholder="contato@empresa.com" />
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">URL do Google</label>
                                        <input type="url" className="w-full" placeholder="https://maps.google.com/..." />
                                    </div>
                                    <div className="flex space-x-3">
                                        <button type="submit" className="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                            Criar Empresa
                                        </button>
                                        <button onClick={() => setCurrentPage('dashboard')} className="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <div className="bg-white p-6 rounded-lg shadow">
                                <h3 className="text-lg font-semibold mb-4">Empresas Cadastradas</h3>
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <span className="font-medium">Restaurante XYZ</span>
                                            <span className="ml-2 text-sm text-gray-500">contato@xyz.com</span>
                                        </div>
                                        <div className="flex space-x-2">
                                            <button className="bg-blue-600 text-white px-3 py-1 rounded text-sm">Editar</button>
                                            <button className="bg-green-600 text-white px-3 py-1 rounded text-sm">Ver URL</button>
                                        </div>
                                    </div>
                                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <span className="font-medium">Loja ABC</span>
                                            <span className="ml-2 text-sm text-gray-500">contato@abc.com</span>
                                        </div>
                                        <div className="flex space-x-2">
                                            <button className="bg-blue-600 text-white px-3 py-1 rounded text-sm">Editar</button>
                                            <button className="bg-green-600 text-white px-3 py-1 rounded text-sm">Ver URL</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )
                },
                reviews: {
                    title: '💬 Avaliações',
                    content: (
                        <div className="space-y-6">
                            <div className="bg-white p-6 rounded-lg shadow">
                                <div className="flex justify-between items-center mb-4">
                                    <h3 className="text-lg font-semibold">Todas as Avaliações</h3>
                                    <div className="flex space-x-2">
                                        <select className="px-3 py-1">
                                            <option>Todas</option>
                                            <option>Positivas</option>
                                            <option>Negativas</option>
                                        </select>
                                        <button className="bg-green-600 text-white px-4 py-1 rounded text-sm">Exportar CSV</button>
                                    </div>
                                </div>
                                
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <span className="font-medium">Restaurante XYZ</span>
                                            <span className="ml-2">⭐⭐⭐⭐⭐</span>
                                            <p className="text-sm text-gray-600 mt-1">📱 (11) 99999-9999</p>
                                            <p className="text-sm text-gray-700">"Excelente comida e atendimento!"</p>
                                        </div>
                                        <div className="flex space-x-2">
                                            <button className="bg-blue-600 text-white px-3 py-1 rounded text-sm">Contatar</button>
                                            <button className="bg-gray-600 text-white px-3 py-1 rounded text-sm">Marcar</button>
                                        </div>
                                    </div>
                                    
                                    <div className="flex items-center justify-between p-3 bg-red-50 rounded border border-red-200">
                                        <div>
                                            <span className="font-medium">Loja ABC</span>
                                            <span className="ml-2">⭐⭐</span>
                                            <p className="text-sm text-gray-600 mt-1">📱 (11) 88888-8888</p>
                                            <p className="text-sm text-gray-700">"Produto não chegou como esperado"</p>
                                            <p className="text-sm text-orange-700 mt-1">Feedback: Produto veio danificado</p>
                                        </div>
                                        <div className="flex space-x-2">
                                            <button className="bg-red-600 text-white px-3 py-1 rounded text-sm">Urgente</button>
                                            <button className="bg-blue-600 text-white px-3 py-1 rounded text-sm">Contatar</button>
                                        </div>
                                    </div>
                                    
                                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <span className="font-medium">Café 123</span>
                                            <span className="ml-2">⭐⭐⭐⭐</span>
                                            <p className="text-sm text-gray-600 mt-1">📱 (11) 77777-7777</p>
                                            <p className="text-sm text-gray-700">"Muito bom, recomendo!"</p>
                                        </div>
                                        <div className="flex space-x-2">
                                            <button className="bg-blue-600 text-white px-3 py-1 rounded text-sm">Contatar</button>
                                            <button className="bg-gray-600 text-white px-3 py-1 rounded text-sm">Marcar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )
                },
                negatives: {
                    title: '⚠️ Avaliações Negativas',
                    content: (
                        <div className="space-y-6">
                            <div className="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div className="flex items-center">
                                    <span className="text-2xl mr-3">🚨</span>
                                    <div>
                                        <h3 className="text-lg font-medium text-red-900">Atenção Urgente</h3>
                                        <p className="text-sm text-red-700">Você tem 2 avaliações negativas que precisam de contato imediato</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div className="bg-white p-6 rounded-lg shadow">
                                <h3 className="text-lg font-semibold mb-4">Avaliações Negativas</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between p-3 bg-red-50 rounded border border-red-200">
                                        <div>
                                            <span className="font-medium">Loja ABC</span>
                                            <span className="ml-2">⭐⭐</span>
                                            <span className="ml-2 bg-red-100 text-red-800 px-2 py-1 rounded text-xs">URGENTE</span>
                                            <p className="text-sm text-gray-600 mt-1">📱 (11) 88888-8888</p>
                                            <p className="text-sm text-gray-700">"Produto não chegou como esperado"</p>
                                            <p className="text-sm text-orange-700 mt-1">Feedback: Produto veio danificado e atendimento ruim</p>
                                        </div>
                                        <div className="flex space-x-2">
                                            <button className="bg-red-600 text-white px-3 py-1 rounded text-sm">Contatar Agora</button>
                                            <button className="bg-green-600 text-white px-3 py-1 rounded text-sm">Marcar Contatado</button>
                                        </div>
                                    </div>
                                    
                                    <div className="flex items-center justify-between p-3 bg-red-50 rounded border border-red-200">
                                        <div>
                                            <span className="font-medium">Hotel Premium</span>
                                            <span className="ml-2">⭐</span>
                                            <span className="ml-2 bg-red-100 text-red-800 px-2 py-1 rounded text-xs">URGENTE</span>
                                            <p className="text-sm text-gray-600 mt-1">📱 (11) 66666-6666</p>
                                            <p className="text-sm text-gray-700">"Atendimento terrível"</p>
                                            <p className="text-sm text-orange-700 mt-1">Feedback: Funcionários mal educados e quarto sujo</p>
                                        </div>
                                        <div className="flex space-x-2">
                                            <button className="bg-red-600 text-white px-3 py-1 rounded text-sm">Contatar Agora</button>
                                            <button className="bg-green-600 text-white px-3 py-1 rounded text-sm">Marcar Contatado</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )
                }
            };
            
            return (
                <div className="min-h-screen bg-gray-100">
                    {/* Header */}
                    <div className="bg-white shadow-sm border-b">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div className="flex justify-between items-center h-16">
                                <div className="flex items-center">
                                    <h1 className="text-xl font-bold text-gray-900">Reviews Platform</h1>
                                </div>
                                <div className="flex items-center space-x-4">
                                    <span className="text-sm text-gray-500">Admin</span>
                                    <button className="text-sm text-gray-500 hover:text-gray-700">Sair</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {/* Navigation */}
                    <div className="bg-white shadow-sm border-b">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <nav className="flex space-x-8">
                                {Object.keys(pages).map((pageKey) => (
                                    <button
                                        key={pageKey}
                                        onClick={() => setCurrentPage(pageKey)}
                                        className={`py-4 px-1 border-b-2 font-medium text-sm ${
                                            currentPage === pageKey
                                                ? 'border-blue-500 text-blue-600'
                                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }`}
                                    >
                                        {pages[pageKey].title}
                                    </button>
                                ))}
                            </nav>
                        </div>
                    </div>
                    
                    {/* Main Content */}
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div className="mb-6">
                            <h2 className="text-2xl font-bold text-gray-900">{pages[currentPage].title}</h2>
                            <p className="mt-1 text-sm text-gray-500">
                                {currentPage === 'dashboard' && 'Visão geral da plataforma de avaliações'}
                                {currentPage === 'companies' && 'Gerencie suas empresas cadastradas'}
                                {currentPage === 'reviews' && 'Todas as avaliações recebidas'}
                                {currentPage === 'negatives' && 'Avaliações que precisam de atenção'}
                            </p>
                        </div>
                        
                        {pages[currentPage].content}
                    </div>
                    
                    {/* Footer */}
                    <div className="bg-white border-t mt-12">
                        <div className="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            <div className="text-center text-sm text-gray-500">
                                <p>Reviews Platform - Sistema de Avaliações</p>
                                <p className="mt-1">✅ Tailwind CSS local implementado - Sem avisos de produção!</p>
                            </div>
                        </div>
                    </div>
                </div>
            );
        };
        
        ReactDOM.render(<App />, document.getElementById('root'));
    </script>
</body>
</html>