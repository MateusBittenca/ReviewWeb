#!/bin/bash

# Script de inicialização para Docker
echo "🚀 Iniciando Reviews Platform..."

# Aguardar MySQL estar pronto
echo "⏳ Aguardando MySQL..."
sleep 10
echo "✅ MySQL pronto!"

# Executar migrations
echo "📊 Executando migrations..."
php artisan migrate --force

# Executar seeders
echo "🌱 Executando seeders..."
php artisan db:seed --force

# Limpar cache
echo "🧹 Limpando cache..."
php artisan config:clear
php artisan cache:clear

# Iniciar servidor
echo "🌐 Iniciando servidor Laravel..."
php artisan serve --host=0.0.0.0 --port=8000
