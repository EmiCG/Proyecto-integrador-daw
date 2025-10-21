<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_cliente' => $this->faker->name(),
            'telefono_cliente' => $this->faker->phoneNumber(),
            'direccion_cliente_escrita' => $this->faker->address(),
            'direccion_cliente_ubicacion' =>$this->faker->url(),
            'order_referencia'=> $this->faker->unique()->word(),
            //'total' => $this->faker->randomFloat(2, 10, 1000), // Total del pedido
            'created_at'=> now(),
            'updated_at' => now(),
            'estado_pago' => $this->faker->randomElement(['pagado', 'por pagar']),
            'estado_produccion' => $this->faker->randomElement(['preparacion', 'enviado', 'entregado', 'cancelado']),
        ];
    }

    public function withProducts(int $count = 2): static
    {
        return $this->afterCreating(function ($order) use ($count) {
            // Crear productos y asociarlos al pedido
            $products = Product::factory()->count($count)->create();
    
            $total = 0; // Inicializa el total del pedido
    
            foreach ($products as $product) {
                $cantidad = $this->faker->numberBetween(1, 5);
                $precio_unitario = $product->precio;
    
                // Asocia el producto al pedido en la tabla pivote
                $order->productos()->attach($product->id, [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio_unitario,
                ]);
    
                // Suma el subtotal del producto al total del pedido
                $total += $cantidad * $precio_unitario;
            }
    
            // Actualiza el total del pedido
            $order->update(['total' => $total]);
        });
    }
    
}
