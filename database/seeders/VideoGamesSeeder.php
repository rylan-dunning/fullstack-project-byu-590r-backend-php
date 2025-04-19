<?php

namespace Database\Seeders;

use App\Models\VideoGame;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Hollow Knight',
                'description' => 'A challenging 2D action-adventure game set in a vast interconnected world. Players control a small knight exploring Hallownest, a kingdom of insects and heroes.',
                'file' => 'images/hk.png',
                'year' => '2017',
                'esrb_rating_id' => 2, // E10+
            ],
            [
                'title' => 'The Legend of Zelda: Breath of the Wild',
                'description' => 'An open-world action-adventure game that reimagines the Zelda formula. Players explore a vast kingdom of Hyrule while battling enemies and solving puzzles.',
                'file' => 'images/botw.jpg',
                'year' => '2017',
                'esrb_rating_id' => 2, // E10+
            ],
            [
                'title' => 'God of War (2018)',
                'description' => 'A third-person action-adventure game following Kratos and his son Atreus on a journey through Norse mythology. Features intense combat and an emotional story.',
                'file' => 'images/gow.jpg',
                'year' => '2018',
                'esrb_rating_id' => 4, // M
            ],
            [
                'title' => 'Helldivers 2',
                'description' => 'A cooperative third-person shooter where players fight to protect Super Earth from alien threats. Features chaotic combat and friendly fire.',
                'file' => 'images/hd2.jpg',
                'year' => '2024',
                'esrb_rating_id' => 4, // M
            ],
            [
                'title' => 'Fortnite',
                'description' => 'A battle royale game where 100 players fight to be the last person standing. Features building mechanics and regular content updates.',
                'file' => 'images/fn.jpg',
                'year' => '2017',
                'esrb_rating_id' => 3, // T
            ],
            [
                'title' => 'Elden Ring',
                'description' => 'An open-world action RPG developed by FromSoftware in collaboration with George R.R. Martin. Features challenging combat and a vast, interconnected world.',
                'file' => 'images/er.jpg',
                'year' => '2022',
                'esrb_rating_id' => 4, // M
            ],
            
        ];
        VideoGame::insert($games);
    }
}
