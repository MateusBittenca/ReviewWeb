# Dockerfile para Reviews Platform
#
# SEGURANÇA: Este Dockerfile NÃO contém secrets hardcoded.
# Todas as variáveis sensíveis (APP_KEY, DB_PASSWORD, MAIL_PASSWORD, etc.)
# são fornecidas em RUNTIME via variáveis de ambiente:
# - Railway: Painel de configuração → Variables
# - Docker: docker run -e VAR=value
# - Docker Compose: Arquivo .env (não commitado no git)
#
# Nenhum ARG ou ENV com secrets está presente neste arquivo.

FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    wget \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos de configuração primeiro (para melhor cache)
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Instalar dependências PHP (sem dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copiar resto dos arquivos (exceto .env que está no .dockerignore)
COPY . .

# Instalar dependências Node (se necessário)
RUN if [ -f package.json ]; then npm ci --only=production || true; fi

# NOTA: O arquivo .env NÃO deve ser copiado para a imagem Docker
# As variáveis de ambiente devem ser fornecidas em runtime via:
# - docker run -e VAR=value
# - docker-compose.yml environment section
# - Plataformas como Railway/Heroku via painel de configuração

# Definir permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copiar script de inicialização
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expor porta
EXPOSE 8000

# Comando de inicialização
# NOTA: Secrets devem ser passados via variáveis de ambiente em runtime,
# não via ARG ou ENV no Dockerfile para evitar exposição
CMD ["/usr/local/bin/docker-entrypoint.sh"]
