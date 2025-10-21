<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente');
            $table->string('telefono_cliente');
            $table->string('direccion_cliente_escrita');
            $table->string('direccion_cliente_ubicacion'); // URL de google maps (no se aun como consume la api de google maps las ubicaciones)
            $table->string('order_referencia')->unique(); // Número de referencia del pedido
            $table->decimal('total', 8, 2)->default(0.00); // Total del pedido
            $table->string('estado_produccion')->default('preparacion'); // Estado del pedido (preparacion, enviado, entregado, cancelado), 
            $table->string('estado_pago')->default('por pagar'); // Estado del pago (pagado, por pagar)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
