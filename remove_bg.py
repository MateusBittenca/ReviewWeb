#!/usr/bin/env python3
"""
Script para remover fundo branco de imagem PNG
"""
from PIL import Image
import sys
import os

def remove_white_background(input_path, output_path, threshold=240):
    """
    Remove fundo branco de uma imagem PNG
    
    Args:
        input_path: Caminho da imagem original
        output_path: Caminho para salvar a imagem processada
        threshold: Limiar de branco (0-255). Valores acima deste são considerados branco
    """
    try:
        # Abrir a imagem
        img = Image.open(input_path)
        
        # Converter para RGBA se necessário
        if img.mode != 'RGBA':
            img = img.convert('RGBA')
        
        # Obter dados dos pixels
        data = img.getdata()
        
        # Criar nova lista de pixels
        new_data = []
        for item in data:
            # Se o pixel for branco (todos os canais RGB acima do threshold)
            # Torná-lo transparente
            if item[0] >= threshold and item[1] >= threshold and item[2] >= threshold:
                new_data.append((255, 255, 255, 0))  # Transparente
            else:
                new_data.append(item)  # Manter o pixel original
        
        # Atualizar dados da imagem
        img.putdata(new_data)
        
        # Salvar a imagem processada
        img.save(output_path, 'PNG')
        print(f"Imagem processada com sucesso! Salva em: {output_path}")
        return True
        
    except Exception as e:
        print(f"Erro ao processar imagem: {e}")
        return False

if __name__ == "__main__":
    input_file = "reviews-platform/public/assets/images/lopgosDASHBOARD.png"
    output_file = "reviews-platform/public/assets/images/lopgosDASHBOARD.png"
    
    if os.path.exists(input_file):
        print(f"Processando: {input_file}")
        remove_white_background(input_file, output_file, threshold=240)
    else:
        print(f"Arquivo não encontrado: {input_file}")

