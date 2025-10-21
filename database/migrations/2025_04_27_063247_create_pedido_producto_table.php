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
        Schema::create('pedido_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Clave foránea para pedidos
            $table->unsignedBigInteger('product_id'); // Clave foránea para productos
            $table->integer('cantidad')->default(1); // Cantidad del producto en el pedido
            $table->decimal('precio_unitario', 8, 2)->default(0.00); // Precio del producto en el momento del pedido
            // $table->timestamps();
            // Relación con la tabla pedidos
            $table->foreign('order_id')->references('id')->on('pedidos')->onDelete('cascade');

            // Relación con la tabla productos
            $table->foreign('product_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_producto');
    }
};
