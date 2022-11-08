<?php

namespace App\Http\Resources\Roulette;

use App\Http\Resources\CarModel\CarModelCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class RouletteResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->price,
            "cars" => new CarModelCollection($this->cars)
        ];
    }
}
