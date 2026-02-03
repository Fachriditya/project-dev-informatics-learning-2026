<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Track;
use Illuminate\Support\Str;

class TrackSeeder extends Seeder
{
    public function run(): void
    {
        $tracks = [
            [
                'name' => 'Software Development',
                'slug' => 'software-development',
                'description' => 'Fokus pada pengembangan software dan aplikasi',
                'color' => '#EF4444',
                'order' => 1,
            ],
            [
                'name' => 'Database Engineering',
                'slug' => 'database-engineering',
                'description' => 'Fokus pada desain, implementasi, dan optimasi database',
                'color' => '#F97316',
                'order' => 2,
            ],
            [
                'name' => 'Systems Analysis & Design',
                'slug' => 'systems-analysis-design',
                'description' => 'Fokus pada analisis dan perancangan sistem informasi',
                'color' => '#EAB308',
                'order' => 3,
            ],
            [
                'name' => 'Cloud Computing',
                'slug' => 'cloud-computing',
                'description' => 'Fokus pada teknologi cloud dan infrastruktur modern',
                'color' => '#22C55E',
                'order' => 4,
            ],
            [
                'name' => 'Artificial Intelligence & Machine Learning',
                'slug' => 'ai-machine-learning',
                'description' => 'Fokus pada AI, ML, dan data science',
                'color' => '#3B82F6',
                'order' => 5,
            ],
            [
                'name' => 'Computer Systems & Architecture',
                'slug' => 'computer-systems-architecture',
                'description' => 'Fokus pada arsitektur komputer dan sistem embedded',
                'color' => '#6366F1',
                'order' => 6,
            ],
            [
                'name' => 'Computer Networks & Security',
                'slug' => 'computer-networks-security',
                'description' => 'Fokus pada jaringan komputer dan keamanan sistem',
                'color' => '#8B5CF6',
                'order' => 7,
            ],
        ];

        foreach ($tracks as $track) {
            Track::create($track);
        }
    }
}