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
        Schema::table('pedido_producto', function (Blueprint $table) {
            if (!Schema::hasColumn('pedido_producto', 'cantidad_recibida')) {
                $table->integer('cantidad_recibida')->default(0)->after('cantidad');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedido_producto', function (Blueprint $table) {
            if (Schema::hasColumn('pedido_producto', 'cantidad_recibida')) {
                $table->dropColumn('cantidad_recibida');
            }
        });
    }
};
