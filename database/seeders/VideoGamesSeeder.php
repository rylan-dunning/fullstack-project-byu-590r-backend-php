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
                'file' => 'images/hollow_knight.jpg',
            ],
            // [
            //     //five other games
            // ]
            
        ];
        VideoGame::insert($games);
    }
}
