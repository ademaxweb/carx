<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CarModel;

class Brand extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['founding'];

    protected $fillable = [
        'name', 'founding'
    ];

    public function cars()
    {
        return $this->hasMany(CarModel::class);
    }
}
