<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roulette extends Model
{
    use HasFactory;
    protected $fillable = [
      "price",
      "name"
    ];

    protected $dates = [
      "created_at",
      "updated_at"
    ];


    public function cars()
    {
        return $this->belongsToMany(CarModel::class)->orderBy('cost');
    }
}
