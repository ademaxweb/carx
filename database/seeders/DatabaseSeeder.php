<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Roulette;
use Illuminate\Database\Seeder;
use function GuzzleHttp\Promise\all;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Brand::factory()->createMany([
           ['name' => 'Mercedes', 'founding'=>date("Y-m-d", mktime(0, 0, 0, 6, 28, 1926))],
           ['name' => 'BMW', 'founding'=>date("Y-m-d", mktime(0, 0, 0, 3, 7, 1916))]
        ]);

//        CarModel::factory(5)->create();
//
//        Roulette::factory()->createMany([
//            ['name' => 'Test #1', 'price' => 100],
//            ['name' => 'Test #2', 'price' => 1000],
//            ['name' => 'Test #3', 'price' => 10000],
//        ]);


        foreach (Roulette::all() as $roulette){
            $roulette->cars()->attach(CarModel::query()->inRandomOrder()->limit(3)->get());
        }

    }
}
