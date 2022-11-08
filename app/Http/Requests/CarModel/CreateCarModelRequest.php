<?php

namespace App\Http\Requests\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "realise" => ["required", "integer"],
            "cost" => ["required", "integer"],
            "name" => ["required", "string"],
            "brand" => ["required", "string"],
            "image" => ["string"]
        ];
    }
}
