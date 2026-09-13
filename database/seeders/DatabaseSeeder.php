<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ],
        );

        $this->call(EventSeeder::class);

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Stellar Surge',
                'logo_path' => 'logos/Main logo.png',
                'favicon_path' => 'logos/Main logo.png',
                'events_logo_path' => 'logos/Events.png',
                'growth_logo_path' => 'logos/Entrepreneirship.png',
                'training_logo_path' => 'logos/Training.png',
                'events_color' => '#E17B7C',
                'growth_color' => '#F9AD2D',
                'training_color' => '#159D99',
                'plum_color' => '#32152F',
                'gold_color' => '#C8A46A',
                'ivory_color' => '#F7F2E9',
                'contact_email' => 'hello@thestellarsurge.com',
                'whatsapp_number' => env('WHATSAPP_NUMBER'),
                'social_links' => [
                    ['label' => 'Instagram', 'url' => 'https://www.instagram.com/thestellarsurge/', 'logo_path' => null],
                    ['label' => 'Facebook', 'url' => 'https://web.facebook.com/stellar.surge/', 'logo_path' => null],
                    ['label' => 'X / Twitter', 'url' => 'https://x.com/TheStellarSurge', 'logo_path' => null],
                ],
                'footer_credit' => 'Developed and Designed by DALE QUIST [Enable Technologies]',
            ],
        );
    }
}
