<?php

namespace Database\Seeders;

use App\Models\EsrbRating;
use Illuminate\Database\Seeder;

class EsrbRatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ratings = [
            [
                'code' => 'E',
                'name' => 'Everyone',
                'description' => 'Content is generally suitable for all ages. May contain minimal cartoon, fantasy or mild violence and/or infrequent use of mild language.'
            ],
            [
                'code' => 'E10+',
                'name' => 'Everyone 10+',
                'description' => 'Content is generally suitable for ages 10 and up. May contain more cartoon, fantasy or mild violence, mild language and/or minimal suggestive themes.'
            ],
            [
                'code' => 'T',
                'name' => 'Teen',
                'description' => 'Content is generally suitable for ages 13 and up. May contain violence, suggestive themes, crude humor, minimal blood, simulated gambling and/or infrequent use of strong language.'
            ],
            [
                'code' => 'M',
                'name' => 'Mature',
                'description' => 'Content is generally suitable for ages 17 and up. May contain intense violence, blood and gore, sexual content and/or strong language.'
            ],
            [
                'code' => 'RP',
                'name' => 'Rating Pending',
                'description' => 'Not yet assigned a final ESRB rating.'
            ],
            // [
            //     'code' => 'AO',
            //     'name' => 'Adults Only',
            //     'description' => 'Content suitable only for adults ages 18 and up. May include prolonged scenes of intense violence, graphic sexual content and/or gambling with real currency.'
            // ],

        ];

        EsrbRating::insert($ratings);
    }
}