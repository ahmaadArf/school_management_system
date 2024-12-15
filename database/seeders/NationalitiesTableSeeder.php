<?php

namespace Database\Seeders;

use App\Models\Nationalitie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationals = [

            [
                'en'=> 'Afghan',
                'ar'=> 'أفغانستاني'
            ],
            [

                'en'=> 'Albanian',
                'ar'=> 'ألباني'
            ],
            [

                'en'=> 'Aland Islander',
                'ar'=> 'آلاندي'
            ],
            [

                'en'=> 'Algerian',
                'ar'=> 'جزائري'
            ],
            [

                'en'=> 'Palestinian',
                'ar'=> 'فلسطيني'
            ],
        ];
        foreach ($nationals as $n) {
            Nationalitie::create(['Name' => $n]);
        }
    }
}
