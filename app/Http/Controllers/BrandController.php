<?php

namespace App\Http\Controllers;

use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function byId($id)
    {
        return new BrandResource(Brand::query()->findOrFail($id)->first());
    }

    public function all()
    {
        return new BrandCollection(Brand::all());
    }

}
