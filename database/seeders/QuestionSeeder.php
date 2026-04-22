<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('questions')->insert([
                'name' => $faker->name,
                'question' => '¿' . $faker->sentence . '?',
                'status' => 1,
                'topic_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
