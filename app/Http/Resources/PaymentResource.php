<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        switch (true) {
            case $this->payable instanceof Order:
                $resource = OrderResource::class;
                break;
            default:
                throw new \Exception("unknown payable type");
                break;
        }

        $this->load('payable');

        return [
            'identifier' => $this->identifier,
            'status' => $this->status,
            'amount' => $this->amount,
            'is_paid' => $this->is_paid,
            'payable' => $resource::make($this->payable),
            'payable_type' => $this->payable_type,
        ];
    }
}
