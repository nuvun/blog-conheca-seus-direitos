<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\ContentCategory;
use Illuminate\Database\Seeder;

class ContentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'type_category_id' => 1,
                'name'        => 'Direito Administrativo',
                'description' => 'Direito Administrativo é o ramo do Direito Público que regula a organização e funcionamento da Administração Pública, bem como as relações entre esta e os particulares.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito Contratual',
                'description' => 'Direito Contratual é o ramo do Direito Privado que regula as relações jurídicas decorrentes de contratos, estabelecendo direitos e obrigações entre as partes.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito das Sucessões',
                'description' => 'Direito das Sucessões é o ramo do Direito Privado que regula a transmissão de bens, direitos e obrigações após a morte de uma pessoa.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito de Família',
                'description' => 'Direito de Família é o ramo do Direito Privado que regula as relações familiares, incluindo casamento, divórcio, guarda de filhos e pensão alimentícia.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito do Consumidor',
                'description' => 'Direito do Consumidor é o ramo do Direito que protege os direitos dos consumidores em suas relações com fornecedores de bens e serviços.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito Imobiliário',
                'description' => 'Direito Imobiliário é o ramo do Direito que regula as relações jurídicas relacionadas a imóveis, incluindo compra, venda, locação e financiamento.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito Penal',
                'description' => 'Direito Penal é o ramo do Direito Público que define crimes e penas, regulando a persecução penal e a aplicação da justiça criminal.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito Trabalhista',
                'description' => 'Direito Trabalhista é o ramo do Direito que regula as relações entre empregadores e empregados, incluindo contratos de trabalho, salários e condições laborais.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
            [
                'type_category_id' => 1,
                'name'        => 'Direito Tributário',
                'description' => 'Direito Tributário é o ramo do Direito Público que regula a arrecadação de tributos pelo Estado e os direitos dos contribuintes.',
                'status'      => StatusEnum::ACTIVE->value,
            ],
        ];

        foreach ($rows as $row) {
            ContentCategory::updateOrCreate(
                ['name' => $row['name']],
                [
                    'description' => $row['description'],
                    'status'      => $row['status'],
                ]
            );
        }
    }
}
