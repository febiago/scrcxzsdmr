<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Surat_masuk>
 */
class Surat_masukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomNumber = $this->faker->randomNumber(3);
        $randomDecimal = $this->faker->randomElement([205, 100, 900, '090', 280, 500, 450, 701]);

        $noSurat = $randomNumber.'/'.$randomNumber.'/408.63'.'/'.date('Y');

        return [
            'no_surat' => $noSurat,
            'pengirim' => $this->faker->sentence,
            'perihal' => $this->faker->randomElement(['undangan', 'pemberitahuan', 'edaran']),
            'tgl_surat' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'tgl_diterima' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'ditujukan' => 'Camat Punung',
            'kategori' => '-',
            'keterangan' => '-',
            'image' => 'image.jpg',
            
        ];
    }
}
