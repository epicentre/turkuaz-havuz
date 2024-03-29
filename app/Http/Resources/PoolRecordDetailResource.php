<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PoolRecordDetailResource extends JsonResource
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
            'id' => $this->id,
            'customer_type' => new CustomerTypeResource($this->whenLoaded('customerType')),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'entry_date' => $this->entry_date->format('d-m-Y H:i:s'),
            'exit_date' => optional($this->exit_date)->format('d-m-Y H:i:s')
        ];
    }
}
