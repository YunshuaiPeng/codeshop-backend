<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'identifier' => $this->identifier,
            'status' => $this->status,
            'amount' => $this->amount,
            'is_paid' => $this->is_paid,
            'is_unpaid' => $this->is_unpaid,
            'is_canceled' => $this->is_canceled,
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'items' => $this->when($this->is_paid, OrderItemResource::collection($this->whenLoaded('items'))),
        ];
    }
}
