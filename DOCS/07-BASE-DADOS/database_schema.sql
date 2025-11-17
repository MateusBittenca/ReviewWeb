-- =================================================================
-- SCRIPT DE CRIAÇÃO DO BANCO DE DADOS - REVIEWS PLATFORM
-- =================================================================
-- Baseado nas migrations do Laravel e documentação MD
-- Criado: 2025-10-23
-- =================================================================

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE reviews_platform;

-- =================================================================
-- TABELA: users
-- =================================================================
-- Armazena usuários administrativos da plataforma
-- =================================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL DEFAULT 'user',
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABELA: password_resets
-- =================================================================
-- Armazena tokens para recuperação de senha
-- =================================================================
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABELA: failed_jobs
-- =================================================================
-- Armazena jobs que falharam na execução
-- =================================================================
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABELA: personal_access_tokens
-- =================================================================
-- Armazena tokens de acesso pessoal para API (Laravel Sanctum)
-- =================================================================
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL DEFAULT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABELA: companies
-- =================================================================
-- Armazena informações das empresas/estabelecimentos
-- =================================================================
CREATE TABLE IF NOT EXISTS `companies` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `logo` VARCHAR(255) NULL DEFAULT NULL,
  `background_image` VARCHAR(255) NULL DEFAULT NULL,
  `negative_email` VARCHAR(255) NOT NULL,
  `contact_number` VARCHAR(255) NULL DEFAULT NULL,
  `business_website` VARCHAR(255) NULL DEFAULT NULL,
  `business_address` TEXT NULL DEFAULT NULL,
  `google_business_url` VARCHAR(255) NULL DEFAULT NULL,
  `positive_score` INT NOT NULL DEFAULT 4,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_slug_unique` (`slug`),
  UNIQUE KEY `companies_token_unique` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABELA: reviews
-- =================================================================
-- Armazena as avaliações coletadas dos clientes
-- =================================================================
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` BIGINT UNSIGNED NOT NULL,
  `rating` INT NOT NULL,
  `whatsapp` VARCHAR(255) NULL DEFAULT NULL,
  `comment` TEXT NULL DEFAULT NULL,
  `private_feedback` TEXT NULL DEFAULT NULL,
  `contact_preference` ENUM('whatsapp', 'email', 'phone', 'no_contact') NULL DEFAULT NULL,
  `has_private_feedback` TINYINT(1) NOT NULL DEFAULT 0,
  `is_positive` TINYINT(1) NOT NULL DEFAULT 0,
  `is_processed` TINYINT(1) NOT NULL DEFAULT 0,
  `processed_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_company_id_foreign` (`company_id`),
  KEY `reviews_company_id_rating_index` (`company_id`, `rating`),
  KEY `reviews_company_id_is_positive_index` (`company_id`, `is_positive`),
  CONSTRAINT `reviews_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABELA: review_pages
-- =================================================================
-- Armazena as páginas de avaliação geradas para cada empresa
-- =================================================================
CREATE TABLE IF NOT EXISTS `review_pages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` BIGINT UNSIGNED NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `views_count` INT NOT NULL DEFAULT 0,
  `reviews_count` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `review_pages_token_unique` (`token`),
  KEY `review_pages_company_id_foreign` (`company_id`),
  KEY `review_pages_token_is_active_index` (`token`, `is_active`),
  CONSTRAINT `review_pages_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- TABELA: migrations
-- =================================================================
-- Armazena histórico de migrations do Laravel
-- =================================================================
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- INSERIR REGISTRO DAS MIGRATIONS
-- =================================================================
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2019_08_19_000000_create_failed_jobs_table', 1),
('2019_12_14_000001_create_personal_access_tokens_table', 1),
('2025_10_18_192140_create_companies_table', 1),
('2025_10_18_192424_create_reviews_table', 1),
('2025_10_18_192434_create_review_pages_table', 1),
('2025_10_18_231916_add_url_to_companies_table', 1),
('2025_10_19_163651_add_private_feedback_to_reviews_table', 1),
('2025_10_19_163915_add_private_feedback_to_reviews_table', 1),
('2025_10_19_164228_add_role_to_users_table', 1);

-- =================================================================
-- DADOS DE EXEMPLO - USUÁRIO ADMINISTRADOR
-- =================================================================
-- Senha: password (hash bcrypt)
-- =================================================================
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, NOW(), NOW());

-- =================================================================
-- FIM DO SCRIPT
-- =================================================================
-- Para usar este script:
-- 1. Execute no MySQL: mysql -u root -p < database_schema.sql
-- 2. Ou importe via phpMyAdmin
-- 3. Login padrão: admin@example.com / password
-- =================================================================

