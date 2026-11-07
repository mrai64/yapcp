<?php

namespace Database\Seeders;

use App\Models\ContestCatalogPagesLayoutSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContestCatalogPagesLayoutSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContestCatalogPagesLayoutSet::factory()
            ->create([
                'layout_type' => 'empty_page',
                'template_file_path' => 'contests/_templates/empty_page.blade.php',
                'title_en' => 'Empty Page',
                ]);
        ContestCatalogPagesLayoutSet::factory()
            ->create([
                'layout_type' => 'cover',
                'template_file_path' => 'contests/_templates/cover.blade.php',
                'title_en' => 'Cover Page',
                ]);
        ContestCatalogPagesLayoutSet::factory()
            ->create([
                'layout_type' => 'admit_work',
                'template_file_path' => 'contests/_templates/admit_work.blade.php',
                'title_en' => 'Image Admit Page',
                ]);
        ContestCatalogPagesLayoutSet::factory()
            ->create([
                'layout_type' => 'winner_work',
                'template_file_path' => 'contests/_templates/winner_work.blade.php',
                'title_en' => 'Winner Image Page',
                ]);
        ContestCatalogPagesLayoutSet::factory()
            ->create([
                'layout_type' => 'winner_name',
                'template_file_path' => 'contests/_templates/winner_name.blade.php',
                'title_en' => 'Winner Name Page',
                ]);
        ContestCatalogPagesLayoutSet::factory()
            ->create([
                'layout_type' => 'book_page',
                'template_file_path' => 'contests/_templates/book_page.blade.php',
                'title_en' => 'Book Text Page',
                ]);
    }
}
