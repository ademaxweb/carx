<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarModel\CreateCarModelRequest;
use App\Http\Resources\CarModel\CarModelCollection;
use App\Http\Resources\CarModel\CarModelResource;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function byId(CarModel $car)
    {
        return new CarModelResource($car);
    }

    public function all()
    {
        return new CarModelCollection(CarModel::all());
    }

    public function create(CreateCarModelRequest $request)
    {
        $data = $request->validated();
//        return response()->json($data);
        $brand = Brand::query()->where("name", $data["brand"])->firstOrFail();
        unset($data["brand"]);
        $carModel = $brand->cars()->create($data);
        if ($data["image"]) $carModel->image = $data["image"];
        $carModel->save();
        $carModel->refresh();
        return response()->json($carModel);

    }
}
