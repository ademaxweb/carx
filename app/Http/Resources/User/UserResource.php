<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'admin' => $this->admin,
            'email' => $this->email,
            'balance' => $this->balance,
            'owning_cars' => $this->cars->count(),
            'cars' => new PersonalCarCollection($this->cars),

        ];
    }
}
