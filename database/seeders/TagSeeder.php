<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Postgres',
            'Neon',
            'Web Development',
            'Laravel',
            'PHP',
            'JavaScript',
            'Database',
            'Design',
            'UI/UX',
            'AI',
            'Machine Learning',
            'Cloud Computing',
            'DevOps',
            'Security',
        ];

        foreach ($tags as $tagName) {
            Tag::create(['tag' => $tagName]);
        }
    }
}
