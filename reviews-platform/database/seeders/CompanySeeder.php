<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\ReviewPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar empresa de exemplo
        $company = Company::create([
            'name' => 'Restaurante XYZ',
            'negative_email' => 'contato@restaurantexyz.com',
            'contact_number' => '(11) 99999-9999',
            'business_website' => 'https://www.restaurantexyz.com',
            'business_address' => 'Rua das Flores, 123 - Centro, São Paulo - SP',
            'google_business_url' => 'https://g.page/restaurante-xyz',
            'positive_score' => 4
        ]);

        // Criar página de avaliação
        ReviewPage::create([
            'company_id' => $company->id,
            'token' => $company->token,
            'url' => $company->public_url,
        ]);

        echo "Empresa criada: {$company->name}\n";
        echo "Token: {$company->token}\n";
        echo "URL Pública: {$company->public_url}\n";
    }
}
