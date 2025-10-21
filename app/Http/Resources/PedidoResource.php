<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre_cliente' => $this->nombre_cliente,
            'telefono_cliente' => $this->telefono_cliente,
            'direccion_cliente_escrita' => $this->direccion_cliente_escrita,
            'direccion_cliente_ubicacion' => $this->direccion_cliente_ubicacion,
            'order_referencia' => $this->order_referencia,
            'total' => $this->total,
            'estado_pago' => $this->estado_pago,
            'estado_produccion' => $this->estado_produccion,
            'productos' => ProductoResource::collection($this->productos), // Relación con productos
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
