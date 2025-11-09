<div class="relative language-selector-wrapper">
    <select 
        class="language-selector-element appearance-none bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 pr-8 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent cursor-pointer transition-colors"
        style="min-height: 44px; font-size: 16px; -webkit-appearance: none; -moz-appearance: none;"
    >
        <option value="pt_BR" {{ app()->getLocale() === 'pt_BR' ? 'selected' : '' }}>
            🇧🇷 Português
        </option>
        <option value="en_US" {{ app()->getLocale() === 'en_US' ? 'selected' : '' }}>
            🇬🇧 English
        </option>
    </select>
    
    <!-- Ícone de seta customizado -->
    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
    </div>
</div>

<script>
(function() {
    // Usar IIFE para evitar conflitos e garantir que funciona mesmo com múltiplas instâncias
    function initLanguageSelectors() {
        const selectors = document.querySelectorAll('.language-selector-element');
        
        selectors.forEach(function(selector) {
            // Remover listener anterior se existir para evitar duplicação
            const newSelector = selector.cloneNode(true);
            selector.parentNode.replaceChild(newSelector, selector);
            
            // Adicionar listener
            newSelector.addEventListener('change', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const locale = this.value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                
                if (!csrfToken) {
                    console.error('CSRF token não encontrado');
                    return;
                }
                
                // Trocar idioma
                fetch('/change-locale', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ locale: locale })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Resposta não OK');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Recarregar página com o novo idioma
                        window.location.reload();
                    } else {
                        console.error('Erro ao trocar idioma:', data);
                        alert('Erro ao trocar idioma. Tente novamente.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao trocar idioma. Tente novamente.');
                });
            });
            
            // Adicionar eventos touch para melhor suporte mobile
            newSelector.addEventListener('touchstart', function(e) {
                e.stopPropagation();
            }, { passive: true });
            
            newSelector.addEventListener('touchend', function(e) {
                e.stopPropagation();
                // Forçar abertura do dropdown no mobile
                if (window.innerWidth < 1024) {
                    this.focus();
                    this.click();
                }
            }, { passive: true });
        });
    }
    
    // Executar quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLanguageSelectors);
    } else {
        initLanguageSelectors();
    }
})();
</script>

