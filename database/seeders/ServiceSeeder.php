<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Plumbing',
                'name_ar' => 'سباكة',
                'name_fr' => 'Plomberie',
                'description' => 'Pipe repairs, installations, and maintenance',
                'icon' => '🔧',
            ],
            [
                'name' => 'Electrical',
                'name_ar' => 'كهرباء',
                'name_fr' => 'Électricité',
                'description' => 'Wiring, repairs, and electrical installations',
                'icon' => '⚡',
            ],
            [
                'name' => 'Carpentry',
                'name_ar' => 'نجارة',
                'name_fr' => 'Menuiserie',
                'description' => 'Woodwork, furniture, and repairs',
                'icon' => '🪚',
            ],
            [
                'name' => 'Painting',
                'name_ar' => 'دهان',
                'name_fr' => 'Peinture',
                'description' => 'Interior and exterior painting services',
                'icon' => '🎨',
            ],
            [
                'name' => 'Cleaning',
                'name_ar' => 'تنظيف',
                'name_fr' => 'Nettoyage',
                'description' => 'Home and office cleaning services',
                'icon' => '🧹',
            ],
            [
                'name' => 'HVAC',
                'name_ar' => 'تكييف وتدفئة',
                'name_fr' => 'Climatisation',
                'description' => 'Heating, ventilation, and air conditioning',
                'icon' => '❄️',
            ],
            [
                'name' => 'Landscaping',
                'name_ar' => 'تنسيق حدائق',
                'name_fr' => 'Aménagement paysager',
                'description' => 'Garden design and maintenance',
                'icon' => '🌳',
            ],
            [
                'name' => 'Roofing',
                'name_ar' => 'أسقف',
                'name_fr' => 'Toiture',
                'description' => 'Roof repairs and installations',
                'icon' => '🏠',
            ],
            [
                'name' => 'Appliance Repair',
                'name_ar' => 'إصلاح الأجهزة',
                'name_fr' => 'Réparation d\'appareils',
                'description' => 'Repair of household appliances',
                'icon' => '🔌',
            ],
            [
                'name' => 'Masonry',
                'name_ar' => 'بناء',
                'name_fr' => 'Maçonnerie',
                'description' => 'Brickwork, stonework, and concrete',
                'icon' => '🧱',
            ],
            [
                'name' => 'Locksmith',
                'name_ar' => 'أقفال',
                'name_fr' => 'Serrurerie',
                'description' => 'Lock installation and repair',
                'icon' => '🔐',
            ],
            [
                'name' => 'Other',
                'name_ar' => 'أخرى',
                'name_fr' => 'Autre',
                'description' => 'Other handyman services',
                'icon' => '🛠️',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('Services seeded successfully!');
    }
}
