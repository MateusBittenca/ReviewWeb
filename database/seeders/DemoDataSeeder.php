<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\ReviewPage;
use App\Models\Review;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Criando dados de demonstração...');

        // Criar 3 empresas de exemplo
        $companies = [
            [
                'name' => 'Restaurante Bom Sabor',
                'email' => 'contato@bomsabor.com.br',
                'google_review_url' => 'https://g.page/r/exemplo1',
                'positive_threshold' => 4,
            ],
            [
                'name' => 'Clínica Saúde Plena',
                'email' => 'contato@saudeplena.com.br',
                'google_review_url' => 'https://g.page/r/exemplo2',
                'positive_threshold' => 4,
            ],
            [
                'name' => 'Auto Center Premium',
                'email' => 'contato@autocenterpremium.com.br',
                'google_review_url' => 'https://g.page/r/exemplo3',
                'positive_threshold' => 5,
            ],
        ];

        foreach ($companies as $companyData) {
            $company = Company::create($companyData);
            
            // Criar página de avaliação
            $reviewPage = ReviewPage::create([
                'company_id' => $company->id,
            ]);

            $this->command->info("✅ {$company->name} criada!");
            $this->command->info("🔗 URL: " . $reviewPage->public_url);

            // Criar algumas avaliações de exemplo
            $this->createSampleReviews($company, $reviewPage);
        }

        $this->command->info('');
        $this->command->info('✨ Dados de demonstração criados com sucesso!');
    }

    private function createSampleReviews(Company $company, ReviewPage $reviewPage): void
    {
        $reviews = [
            // Positivas
            [
                'rating' => 5,
                'whatsapp' => '5511987654321',
                'comment' => 'Excelente atendimento! Recomendo!',
                'is_positive' => true,
                'redirected_to_google' => true,
            ],
            [
                'rating' => 5,
                'whatsapp' => '5511987654322',
                'comment' => 'Muito satisfeito com o serviço.',
                'is_positive' => true,
                'redirected_to_google' => true,
            ],
            [
                'rating' => 4,
                'whatsapp' => '5511987654323',
                'comment' => 'Bom atendimento, voltarei!',
                'is_positive' => true,
                'redirected_to_google' => true,
            ],
            // Negativas
            [
                'rating' => 2,
                'whatsapp' => '5511987654324',
                'comment' => null,
                'feedback' => 'Demora no atendimento e falta de atenção.',
                'is_positive' => false,
                'redirected_to_google' => false,
            ],
            [
                'rating' => 3,
                'whatsapp' => '5511987654325',
                'comment' => null,
                'feedback' => 'Esperava mais qualidade pelo preço.',
                'is_positive' => false,
                'redirected_to_google' => false,
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::create(array_merge($reviewData, [
                'company_id' => $company->id,
                'review_page_id' => $reviewPage->id,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Demo Data Seeder',
            ]));
        }
    }
}





