<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PoolRecordResource extends JsonResource
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
            'detail' => PoolRecordDetailResource::collection($this->whenLoaded('detail')),
            'voucher_no' => $this->voucher_no,
            'customer_count' => $this->customer_count,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'day' => $this->day->format('d-m-Y'),
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s')
        ];
    }
}
