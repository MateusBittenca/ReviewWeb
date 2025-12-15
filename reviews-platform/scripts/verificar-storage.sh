#!/bin/bash

# Script para verificar se o storage está configurado corretamente
# Útil para debug após deploy no Railway

echo "🔍 Verificando configuração do storage..."

# Verificar se os diretórios existem
echo ""
echo "📁 Verificando diretórios:"
if [ -d "storage/app/public/logos" ]; then
    echo "  ✅ storage/app/public/logos existe"
    echo "     Arquivos: $(ls -1 storage/app/public/logos 2>/dev/null | wc -l)"
else
    echo "  ❌ storage/app/public/logos NÃO existe"
fi

if [ -d "storage/app/public/backgrounds" ]; then
    echo "  ✅ storage/app/public/backgrounds existe"
    echo "     Arquivos: $(ls -1 storage/app/public/backgrounds 2>/dev/null | wc -l)"
else
    echo "  ❌ storage/app/public/backgrounds NÃO existe"
fi

if [ -d "storage/app/public/photos" ]; then
    echo "  ✅ storage/app/public/photos existe"
    echo "     Arquivos: $(ls -1 storage/app/public/photos 2>/dev/null | wc -l)"
else
    echo "  ❌ storage/app/public/photos NÃO existe"
fi

# Verificar symlink
echo ""
echo "🔗 Verificando symlink:"
if [ -L "public/storage" ]; then
    echo "  ✅ public/storage é um symlink"
    echo "     Aponta para: $(readlink public/storage)"
else
    echo "  ❌ public/storage NÃO é um symlink"
    echo "     Execute: php artisan storage:link"
fi

# Verificar permissões
echo ""
echo "🔐 Verificando permissões:"
ls -ld storage/app/public 2>/dev/null | awk '{print "  storage/app/public: " $1 " " $3 " " $4}'

# Verificar se há arquivos
echo ""
echo "📊 Estatísticas:"
TOTAL_LOGOS=$(find storage/app/public/logos -type f 2>/dev/null | wc -l)
TOTAL_BGS=$(find storage/app/public/backgrounds -type f 2>/dev/null | wc -l)
TOTAL_PHOTOS=$(find storage/app/public/photos -type f 2>/dev/null | wc -l)
TOTAL=$((TOTAL_LOGOS + TOTAL_BGS + TOTAL_PHOTOS))

echo "  Total de imagens: $TOTAL"
echo "    - Logos: $TOTAL_LOGOS"
echo "    - Backgrounds: $TOTAL_BGS"
echo "    - Photos: $TOTAL_PHOTOS"

# Verificar tamanho total
if [ -d "storage/app/public" ]; then
    SIZE=$(du -sh storage/app/public 2>/dev/null | awk '{print $1}')
    echo "  Tamanho total: $SIZE"
fi

echo ""
echo "✅ Verificação concluída!"

