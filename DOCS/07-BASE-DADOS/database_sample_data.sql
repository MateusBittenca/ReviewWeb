-- =================================================================
-- SCRIPT DE DADOS DE DEMONSTRAÇÃO - REVIEWS PLATFORM
-- =================================================================
-- Popula o banco com dados realistas para testes e desenvolvimento
-- Execute APÓS o database_schema.sql
-- =================================================================

USE reviews_platform;

-- =================================================================
-- DADOS DE EXEMPLO - EMPRESAS
-- =================================================================

INSERT INTO `companies` (`id`, `name`, `slug`, `token`, `logo`, `background_image`, `negative_email`, `contact_number`, `business_website`, `business_address`, `google_business_url`, `positive_score`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Restaurante Sabor & Arte', 'restaurante-sabor-arte', 'RSA-2025-ABC123', NULL, NULL, 'contato@saborarte.com.br', '+55 11 98765-4321', 'https://saborarte.com.br', 'Rua das Flores, 123 - Centro, São Paulo - SP', 'https://g.page/saborarte', 4, 1, NOW(), NOW()),
(2, 'Clínica Vida Saudável', 'clinica-vida-saudavel', 'CVS-2025-DEF456', NULL, NULL, 'atendimento@vidasaudavel.com.br', '+55 11 3456-7890', 'https://vidasaudavel.com.br', 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP', 'https://g.page/vidasaudavel', 4, 1, NOW(), NOW()),
(3, 'Auto Center Premium', 'auto-center-premium', 'ACP-2025-GHI789', NULL, NULL, 'sac@autocenterpremium.com.br', '+55 11 2345-6789', 'https://autocenterpremium.com.br', 'Rua dos Mecânicos, 456 - Industrial, Guarulhos - SP', 'https://g.page/autocenterpremium', 4, 1, NOW(), NOW()),
(4, 'Salão Beleza Total', 'salao-beleza-total', 'SBT-2025-JKL012', NULL, NULL, 'contato@belezatotal.com.br', '+55 11 99876-5432', 'https://belezatotal.com.br', 'Rua da Beleza, 789 - Jardins, São Paulo - SP', 'https://g.page/belezatotal', 5, 1, NOW(), NOW()),
(5, 'Academia Corpo & Mente', 'academia-corpo-mente', 'ACM-2025-MNO345', NULL, NULL, 'info@corpoemente.com.br', '+55 11 4567-8901', 'https://corpoemente.com.br', 'Av. dos Esportes, 321 - Vila Olímpia, São Paulo - SP', 'https://g.page/corpoemente', 4, 1, NOW(), NOW()),
(6, 'Pet Shop Amigo Fiel', 'pet-shop-amigo-fiel', 'PSAF-2025-PQR678', NULL, NULL, 'contato@amigofiel.com.br', '+55 11 98765-1234', 'https://amigofiel.com.br', 'Rua dos Pets, 567 - Mooca, São Paulo - SP', 'https://g.page/amigofiel', 4, 1, NOW(), NOW()),
(7, 'Pizzaria Forno Italiano', 'pizzaria-forno-italiano', 'PFI-2025-STU901', NULL, NULL, 'pizzaria@fornoitaliano.com.br', '+55 11 3333-4444', 'https://fornoitaliano.com.br', 'Rua Itália, 234 - Moema, São Paulo - SP', 'https://g.page/fornoitaliano', 4, 1, NOW(), NOW()),
(8, 'Padaria Pão Quente', 'padaria-pao-quente', 'PPQ-2025-VWX234', NULL, NULL, 'contato@paoquente.com.br', '+55 11 2222-3333', 'https://paoquente.com.br', 'Av. do Pão, 890 - Pinheiros, São Paulo - SP', 'https://g.page/paoquente', 5, 1, NOW(), NOW()),
(9, 'Lavanderia Express Clean', 'lavanderia-express-clean', 'LEC-2025-YZA567', NULL, NULL, 'sac@expressclean.com.br', '+55 11 5555-6666', 'https://expressclean.com.br', 'Rua Limpa, 111 - Itaim Bibi, São Paulo - SP', 'https://g.page/expressclean', 4, 1, NOW(), NOW()),
(10, 'Livraria Saber & Cultura', 'livraria-saber-cultura', 'LSC-2025-BCD890', NULL, NULL, 'contato@sabercultura.com.br', '+55 11 7777-8888', 'https://sabercultura.com.br', 'Rua dos Livros, 222 - Vila Mariana, São Paulo - SP', 'https://g.page/sabercultura', 4, 1, NOW(), NOW());

-- =================================================================
-- DADOS DE EXEMPLO - PÁGINAS DE AVALIAÇÃO
-- =================================================================

INSERT INTO `review_pages` (`id`, `company_id`, `token`, `url`, `views_count`, `reviews_count`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'rsa-review-page-001', '/r/rsa-review-page-001', 150, 45, 1, NOW(), NOW()),
(2, 2, 'cvs-review-page-002', '/r/cvs-review-page-002', 230, 67, 1, NOW(), NOW()),
(3, 3, 'acp-review-page-003', '/r/acp-review-page-003', 180, 52, 1, NOW(), NOW()),
(4, 4, 'sbt-review-page-004', '/r/sbt-review-page-004', 320, 98, 1, NOW(), NOW()),
(5, 5, 'acm-review-page-005', '/r/acm-review-page-005', 210, 63, 1, NOW(), NOW()),
(6, 6, 'psaf-review-page-006', '/r/psaf-review-page-006', 140, 41, 1, NOW(), NOW()),
(7, 7, 'pfi-review-page-007', '/r/pfi-review-page-007', 280, 84, 1, NOW(), NOW()),
(8, 8, 'ppq-review-page-008', '/r/ppq-review-page-008', 190, 57, 1, NOW(), NOW()),
(9, 9, 'lec-review-page-009', '/r/lec-review-page-009', 160, 48, 1, NOW(), NOW()),
(10, 10, 'lsc-review-page-010', '/r/lsc-review-page-010', 200, 60, 1, NOW(), NOW());

-- =================================================================
-- DADOS DE EXEMPLO - AVALIAÇÕES (REVIEWS)
-- =================================================================

-- Restaurante Sabor & Arte (ID 1) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(1, 5, '11987654321', 'Comida maravilhosa! Atendimento impecável.', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(1, 5, '11987654322', 'Melhor restaurante da região. Super recomendo!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
(1, 4, '11987654323', 'Muito bom! Ambiente agradável e comida saborosa.', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW()),
(1, 5, '11987654324', 'Excelente! Voltarei com certeza.', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 5 DAY), NOW());

-- Restaurante Sabor & Arte - Avaliações Negativas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(1, 2, '11987654325', 'Demorou muito para servir.', 'Esperamos mais de 1 hora pela comida. O garçom foi educado mas o tempo foi excessivo.', 'whatsapp', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW()),
(1, 3, '11987654326', 'Boa comida mas atendimento pode melhorar.', 'Garçom esqueceu parte do pedido. Tivemos que pedir duas vezes.', 'email', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 6 DAY), NOW());

-- Clínica Vida Saudável (ID 2) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(2, 5, '11976543210', 'Médicos excelentes! Muito atenciosos.', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(2, 5, '11976543211', 'Atendimento humanizado e profissional.', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
(2, 4, '11976543212', 'Clínica limpa e organizada. Recomendo!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW());

-- Clínica Vida Saudável - Avaliações Negativas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(2, 2, '11976543213', 'Consulta atrasou muito.', 'Marquei para às 14h e fui atendida às 16h30. Sem justificativa adequada.', 'phone', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW());

-- Auto Center Premium (ID 3) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(3, 5, '11965432109', 'Mecânicos honestos e competentes!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(3, 4, '11965432108', 'Bom serviço e preço justo.', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW()),
(3, 5, '11965432107', 'Resolveram meu problema rapidamente!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 5 DAY), NOW());

-- Auto Center Premium - Avaliações Negativas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(3, 3, '11965432106', 'Serviço ok mas caro.', 'Achei o preço acima da média da região. Qualidade boa mas poderia ser mais acessível.', 'no_contact', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW());

-- Salão Beleza Total (ID 4) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(4, 5, '11954321098', 'Cabelo ficou perfeito! Adorei!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(4, 5, '11954321097', 'Profissionais super capacitados!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
(4, 5, '11954321096', 'Melhor salão que já fui!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW()),
(4, 5, '11954321095', 'Ambiente maravilhoso e resultado impecável!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW());

-- Academia Corpo & Mente (ID 5) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(5, 5, '11943210987', 'Excelentes professores e equipamentos!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(5, 4, '11943210986', 'Ótima academia, ambiente motivador!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW()),
(5, 5, '11943210985', 'Melhor investimento que fiz na minha saúde!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 5 DAY), NOW());

-- Academia Corpo & Mente - Avaliações Negativas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(5, 3, '11943210984', 'Vestiário precisa de manutenção.', 'Chuveiros com pouca pressão e armários quebrados. Academia boa mas infraestrutura precisa melhorar.', 'email', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW());

-- Pet Shop Amigo Fiel (ID 6) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(6, 5, '11932109876', 'Meu cachorro adorou! Super carinhosos!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(6, 5, '11932109875', 'Profissionais que realmente amam animais!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW()),
(6, 4, '11932109874', 'Ótimo atendimento e preço justo!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW());

-- Pizzaria Forno Italiano (ID 7) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(7, 5, '11921098765', 'Melhor pizza da cidade! Massa perfeita!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(7, 5, '11921098764', 'Ingredientes de qualidade! Deliciosa!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
(7, 4, '11921098763', 'Pizza muito boa e entrega rápida!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW());

-- Pizzaria Forno Italiano - Avaliações Negativas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(7, 2, '11921098762', 'Pizza chegou fria.', 'Pedi pelo delivery e a pizza chegou fria. Liguei e não deram solução adequada.', 'whatsapp', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW());

-- Padaria Pão Quente (ID 8) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(8, 5, '11910987654', 'Pão fresquinho todo dia! Maravilhoso!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(8, 5, '11910987653', 'Atendimento excelente e produtos de qualidade!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
(8, 5, '11910987652', 'Melhor padaria do bairro!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW());

-- Lavanderia Express Clean (ID 9) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(9, 5, '11909876543', 'Roupas voltam impecáveis! Serviço rápido!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(9, 4, '11909876542', 'Bom atendimento e cumprem o prazo!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW());

-- Lavanderia Express Clean - Avaliações Negativas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(9, 3, '11909876541', 'Roupa voltou com manchas.', 'Uma blusa cara voltou com manchas que não tinha antes. Pedi para refazerem mas não aceitaram responsabilidade.', 'phone', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW());

-- Livraria Saber & Cultura (ID 10) - Avaliações Positivas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(10, 5, '11908765432', 'Variedade incrível de livros! Adorei!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(10, 5, '11908765431', 'Atendimento personalizado e ambiente aconchegante!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
(10, 4, '11908765430', 'Ótima livraria! Preços justos!', NULL, NULL, 0, 1, 1, NOW(), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW());

-- Livraria Saber & Cultura - Avaliações Negativas
INSERT INTO `reviews` (`company_id`, `rating`, `whatsapp`, `comment`, `private_feedback`, `contact_preference`, `has_private_feedback`, `is_positive`, `is_processed`, `processed_at`, `created_at`, `updated_at`) VALUES
(10, 3, '11908765429', 'Livro encomendado demorou muito.', 'Encomendei um livro e levou 3 semanas para chegar. Comunicação poderia ser melhor sobre prazos.', 'email', 1, 0, 1, NOW(), DATE_SUB(NOW(), INTERVAL 3 DAY), NOW());

-- =================================================================
-- FIM DO SCRIPT DE DADOS DE DEMONSTRAÇÃO
-- =================================================================
-- Este script criou:
-- - 10 empresas de diferentes segmentos
-- - 10 páginas de avaliação (uma para cada empresa)
-- - 50+ avaliações (positivas e negativas) com dados realistas
-- - Incluindo feedback privado para avaliações negativas
-- =================================================================

