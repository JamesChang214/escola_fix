<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeeTypesResource extends JsonResource
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
            'name' => $this->name,
            'short_name' => $this->short_name,
            'revenue_start_date' => $this->revenue_start_date ? $this->revenue_start_date->toDateString() : "",
            'revenue_end_date' => $this->revenue_end_date ? $this->revenue_end_date->toDateString() : "",
            'amount' => $this->amount ? $this->amount : 0,
            'payment_instructions' => $this->payment_instructions,
            'small_print' => $this->small_print,
        ];
    }
}
