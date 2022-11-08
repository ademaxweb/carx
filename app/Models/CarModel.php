<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name', 'brand_id', 'cost', 'realise'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function owners()
    {
        return $this->belongsToMany(User::class, 'car_model_users');
    }

    public function roulettes()
    {
        return $this->belongsToMany(Roulette::class);
    }
}
