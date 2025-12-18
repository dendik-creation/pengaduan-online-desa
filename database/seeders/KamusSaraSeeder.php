<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KamusSara;

class KamusSaraSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $saraWords = [
            "kafir",
            "cina",
            "pribumi",
            "aseng",
            "babi",
            "anjing",
            "monyet",
            "buta",
            "kampungan",
            "sialan",
        ];

        foreach ($saraWords as $kata) {
            KamusSara::firstOrCreate(["kata" => $kata]);
        }
    }
}
