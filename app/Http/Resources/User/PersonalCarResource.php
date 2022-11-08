<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalCarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->pivot->id,
            'model' => [
                'id' => $this->id,
                'name' => $this->name,
                'cost' => $this->cost,
                'brand' => $this->brand,
                'realise' => $this->realise,
                'image' => url('storage/images/' . $this->image)
            ]
        ];
    }
}
