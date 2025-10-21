<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   
     
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->text(100),
            'precio' => $this->faker->randomFloat(2,10,200),
            'imagen' =>$this->faker->imageUrl(640, 480, 'products', true),
            'categoria' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
