<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Sepak Bola',
                'category_id' => 1,
                'user_id' => 1,
                'description' => 'Sepak Bola adalah permainan 11 pemain, permainan ini banyak diminati dari kalangan muda hingga tua.'
            ],
            [
                'title' => 'Seorang Anggota DPR Terlihat sedang Bermain Game saat Rapat DPR',
                'category_id' => 2,
                'user_id' => 1,
                'description' => 'Anggota DPR yang bernama PangTong sedang asik bermain game Candy Crush saat rapat sedang berjalan.'
            ],
            [
                'title' => 'Nasi Padang Sukha',
                'category_id' => 3,
                'user_id' => 1,
                'description' => 'Nasi Padang.. yaa, Nasi Padang adalah makanan yang sangat diminati oleh banyak kalangan, dengan rasanya yang penuh rasa bumbu dan juga daging rendang yang gurih dan lembut saat digigit.'
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
