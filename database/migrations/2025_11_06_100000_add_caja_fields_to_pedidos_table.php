<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (! Schema::hasColumn('pedidos', 'efectivo_recibido')) {
                $table->decimal('efectivo_recibido', 10, 2)->nullable()->after('total');
            }
            if (! Schema::hasColumn('pedidos', 'cambio_entregado')) {
                $table->decimal('cambio_entregado', 10, 2)->nullable()->after('efectivo_recibido');
            }
            if (! Schema::hasColumn('pedidos', 'shipping')) {
                $table->decimal('shipping', 10, 2)->nullable()->after('cambio_entregado');
            }
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['efectivo_recibido', 'cambio_entregado', 'shipping']);
        });
    }
};
