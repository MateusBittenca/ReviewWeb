<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\ReviewPage;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompleteDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Criando dados completos da aplicação...');
        $this->command->info('');

        // 1. Criar usuário admin
        $this->createAdminUser();

        // 2. Criar empresas com dados realistas
        $this->createCompanies();

        $this->command->info('');
        $this->command->info('✨ Dados completos criados com sucesso!');
        $this->command->info('');
        $this->command->info('📊 Resumo:');
        $this->command->info('   • 1 usuário admin');
        $this->command->info('   • ' . Company::count() . ' empresas');
        $this->command->info('   • ' . ReviewPage::count() . ' páginas de avaliação');
        $this->command->info('   • ' . Review::count() . ' avaliações');
    }

    private function createAdminUser(): void
    {
        $this->command->info('👤 Criando usuário administrador...');

        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Usuário admin criado: admin@example.com / password');
    }

    private function createCompanies(): void
    {
        $this->command->info('🏢 Criando empresas...');

        $companies = [
            // Restaurantes
            [
                'name' => 'Restaurante Sabor & Arte',
                'email' => 'contato@saborearte.com.br',
                'phone' => '(11) 99999-1111',
                'address' => 'Rua das Flores, 123 - Centro, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/sabor-e-arte',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Restaurante especializado em culinária brasileira com toque contemporâneo.',
            ],
            [
                'name' => 'Pizzaria Bella Vista',
                'email' => 'pedidos@bellavista.com.br',
                'phone' => '(11) 99999-2222',
                'address' => 'Av. Paulista, 456 - Bela Vista, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/bella-vista-pizza',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Pizzaria tradicional com forno a lenha e ingredientes frescos.',
            ],

            // Saúde
            [
                'name' => 'Clínica Vida Saudável',
                'email' => 'agendamento@vidasaudavel.com.br',
                'phone' => '(11) 99999-3333',
                'address' => 'Rua da Saúde, 789 - Jardins, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/vida-saudavel',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Clínica médica com foco em medicina preventiva e bem-estar.',
            ],
            [
                'name' => 'OdontoClinic Premium',
                'email' => 'contato@odontoclinic.com.br',
                'phone' => '(11) 99999-4444',
                'address' => 'Rua dos Dentistas, 321 - Vila Madalena, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/odonto-premium',
                'positive_threshold' => 5,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Clínica odontológica com tecnologia de ponta e atendimento personalizado.',
            ],

            // Serviços Automotivos
            [
                'name' => 'Auto Center Express',
                'email' => 'servicos@autoexpress.com.br',
                'phone' => '(11) 99999-5555',
                'address' => 'Av. das Indústrias, 654 - Zona Industrial, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/auto-express',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Oficina mecânica especializada em manutenção preventiva e corretiva.',
            ],
            [
                'name' => 'Lava Jato Relâmpago',
                'email' => 'contato@relampago.com.br',
                'phone' => '(11) 99999-6666',
                'address' => 'Rua da Limpeza, 987 - Centro, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/lava-relampago',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Lava jato express com produtos premium e atendimento rápido.',
            ],

            // Educação
            [
                'name' => 'Escola Futuro Brilhante',
                'email' => 'secretaria@futurobrilhante.com.br',
                'phone' => '(11) 99999-7777',
                'address' => 'Rua da Educação, 147 - Vila Nova, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/futuro-brilhante',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Escola particular com ensino bilíngue e metodologia inovadora.',
            ],

            // Tecnologia
            [
                'name' => 'Tech Solutions',
                'email' => 'contato@techsolutions.com.br',
                'phone' => '(11) 99999-8888',
                'address' => 'Av. Tecnologia, 258 - Tech Park, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/tech-solutions',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Empresa de desenvolvimento de software e consultoria em TI.',
            ],

            // Beleza e Estética
            [
                'name' => 'Salão Beleza Total',
                'email' => 'agendamento@belezatotal.com.br',
                'phone' => '(11) 99999-9999',
                'address' => 'Rua da Beleza, 369 - Moema, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/beleza-total',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Salão de beleza completo com profissionais especializados.',
            ],

            // Fitness
            [
                'name' => 'Academia Power Gym',
                'email' => 'matriculas@powergym.com.br',
                'phone' => '(11) 99999-0000',
                'address' => 'Av. do Esporte, 741 - Vila Olímpia, São Paulo/SP',
                'google_review_url' => 'https://g.page/r/power-gym',
                'positive_threshold' => 4,
                'logo_path' => null,
                'background_image_path' => null,
                'custom_css' => null,
                'is_active' => true,
                'description' => 'Academia moderna com equipamentos de última geração e personal trainers.',
            ],
        ];

        foreach ($companies as $index => $companyData) {
            $company = Company::create($companyData);
            
            // Criar página de avaliação
            $reviewPage = ReviewPage::create([
                'company_id' => $company->id,
            ]);

            $this->command->info("✅ {$company->name} criada!");
            $this->command->info("🔗 URL: " . $reviewPage->public_url);

            // Criar avaliações realistas para cada empresa
            $this->createRealisticReviews($company, $reviewPage, $index);
        }
    }

    private function createRealisticReviews(Company $company, ReviewPage $reviewPage, int $companyIndex): void
    {
        $reviews = $this->getReviewsByCompanyType($companyIndex);

        foreach ($reviews as $reviewData) {
            Review::create(array_merge($reviewData, [
                'company_id' => $company->id,
                'review_page_id' => $reviewPage->id,
                'ip_address' => $this->getRandomIP(),
                'user_agent' => $this->getRandomUserAgent(),
                'created_at' => $this->getRandomDate(),
                'updated_at' => $this->getRandomDate(),
            ]));
        }
    }

    private function getReviewsByCompanyType(int $companyIndex): array
    {
        $reviewTemplates = [
            // Restaurantes (0, 1)
            [
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654321',
                    'comment' => 'Comida deliciosa e atendimento excelente! Recomendo!',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654322',
                    'comment' => 'Ambiente aconchegante e pratos saborosos. Voltarei!',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 4,
                    'whatsapp' => '5511987654323',
                    'comment' => 'Bom atendimento, comida gostosa. Só demorou um pouco.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 2,
                    'whatsapp' => '5511987654324',
                    'comment' => null,
                    'feedback' => 'Demora no atendimento e comida morna. Esperava mais.',
                    'is_positive' => false,
                    'redirected_to_google' => false,
                ],
            ],

            // Saúde (2, 3)
            [
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654325',
                    'comment' => 'Profissionais muito competentes e ambiente limpo.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654326',
                    'comment' => 'Atendimento humanizado e explicações claras.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 4,
                    'whatsapp' => '5511987654327',
                    'comment' => 'Boa estrutura, mas poderia ter mais horários disponíveis.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 3,
                    'whatsapp' => '5511987654328',
                    'comment' => null,
                    'feedback' => 'Demora para conseguir agendamento e atendimento corrido.',
                    'is_positive' => false,
                    'redirected_to_google' => false,
                ],
            ],

            // Serviços Automotivos (4, 5)
            [
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654329',
                    'comment' => 'Serviço rápido e preço justo. Recomendo!',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654330',
                    'comment' => 'Profissionais honestos e trabalho bem feito.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 4,
                    'whatsapp' => '5511987654331',
                    'comment' => 'Bom atendimento, mas demorou mais que o prometido.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 2,
                    'whatsapp' => '5511987654332',
                    'comment' => null,
                    'feedback' => 'Serviço caro e demora excessiva. Não voltarei.',
                    'is_positive' => false,
                    'redirected_to_google' => false,
                ],
            ],

            // Educação (6)
            [
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654333',
                    'comment' => 'Excelente ensino e professores dedicados.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654334',
                    'comment' => 'Estrutura moderna e metodologia inovadora.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 4,
                    'whatsapp' => '5511987654335',
                    'comment' => 'Boa escola, mas mensalidade alta.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
            ],

            // Tecnologia (7)
            [
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654336',
                    'comment' => 'Soluções inovadoras e equipe técnica excelente.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654337',
                    'comment' => 'Atendimento profissional e entregas no prazo.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 4,
                    'whatsapp' => '5511987654338',
                    'comment' => 'Bom trabalho, mas comunicação poderia ser melhor.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
            ],

            // Beleza (8)
            [
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654339',
                    'comment' => 'Profissionais qualificados e ambiente agradável.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654340',
                    'comment' => 'Resultado excelente e atendimento personalizado.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 4,
                    'whatsapp' => '5511987654341',
                    'comment' => 'Bom serviço, mas preços um pouco altos.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
            ],

            // Fitness (9)
            [
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654342',
                    'comment' => 'Equipamentos modernos e instrutores atenciosos.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 5,
                    'whatsapp' => '5511987654343',
                    'comment' => 'Ambiente motivador e resultados visíveis.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 4,
                    'whatsapp' => '5511987654344',
                    'comment' => 'Boa academia, mas poderia ter mais horários de funcionamento.',
                    'is_positive' => true,
                    'redirected_to_google' => true,
                ],
                [
                    'rating' => 3,
                    'whatsapp' => '5511987654345',
                    'comment' => null,
                    'feedback' => 'Equipamentos antigos e falta de manutenção.',
                    'is_positive' => false,
                    'redirected_to_google' => false,
                ],
            ],
        ];

        return $reviewTemplates[$companyIndex] ?? $reviewTemplates[0];
    }

    private function getRandomIP(): string
    {
        $ips = [
            '177.43.123.45',
            '201.23.67.89',
            '189.45.78.123',
            '200.156.34.67',
            '187.89.45.234',
            '179.123.67.89',
            '198.45.123.67',
            '186.78.234.56',
        ];

        return $ips[array_rand($ips)];
    }

    private function getRandomUserAgent(): string
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15',
            'Mozilla/5.0 (Android 11; Mobile; rv:68.0) Gecko/68.0 Firefox/88.0',
        ];

        return $userAgents[array_rand($userAgents)];
    }

    private function getRandomDate(): string
    {
        $startDate = now()->subDays(30);
        $endDate = now();
        
        $randomTimestamp = mt_rand($startDate->timestamp, $endDate->timestamp);
        
        return date('Y-m-d H:i:s', $randomTimestamp);
    }
}
