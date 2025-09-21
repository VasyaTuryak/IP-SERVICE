<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IpAddress extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'ID' => $this->id,
            'IP_address' => $this->ip,
            'Country' => $this->country,
            'City' => $this->city,
            'Created_at'=>$this->created_at,
            'Updated_at' => $this->updated_at,
        ];
    }

}
