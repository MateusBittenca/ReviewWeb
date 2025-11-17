<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@reviewsplatform.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        $this->command->info('✅ Usuário admin criado!');
        $this->command->info('📧 Email: admin@reviewsplatform.com');
        $this->command->info('🔑 Senha: password123');
    }
}





