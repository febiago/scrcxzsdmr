<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Surat_keluar>
 */
class Surat_keluarFactory extends Factory
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

        $noSurat = $randomDecimal.'/'.$randomNumber.'/408.63'.'/'.date('Y');

        return [
            'no_surat' => $noSurat,
            'perihal' => $this->faker->sentence,
            'tgl_surat' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'tgl_dikirim' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'ditujukan' => $this->faker->name,
            'kategori' => $this->faker->randomElement(['penting', 'biasa', 'segera']),
            'keterangan' => '-',
            'image' => 'image.jpg',
        ];
    }
}
