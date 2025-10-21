<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'pedidos';

    protected $fillable = [
        'nombre_cliente',
        'telefono_cliente',
        'direccion_cliente_escrita',
        'direccion_cliente_ubicacion',
        'order_referencia',
        'total',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'estado_pago',
        'estado_produccion',
    ];

    public function productos()
    {
        return $this->belongsToMany(Product::class, 'pedido_producto')
                    ->withPivot('cantidad', 'precio_unitario');
    }

    public function calcularTotal(): float{

        return $this->productos->sum(function ($producto) {
            return $producto->pivot->cantidad * $producto->pivot->precio_unitario;
        });
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'update_at' => 'datetime'
        ];
    }
}
