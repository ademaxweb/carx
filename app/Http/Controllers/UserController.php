<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\BuyCarRequest;
use App\Http\Requests\User\SellCarRequest;
use App\Http\Resources\User\PersonalCarCollection;
use App\Http\Resources\User\UserResource;
use App\Models\CarModel;
use App\Models\CarModelUser;
use App\Models\User;

class UserController extends Controller
{
    public function byId($id)
    {
        $user = User::query()->find($id);
        if (!$user) return response()->json(["success" => false, "message" => "Аккаунт не найден"], 404);
        return new UserResource($user);
    }

    public function addCar(User $user, CarModel $car)
    {
        $user->cars()->attach($car);
        return $user;
    }

    public function removeCar(CarModelUser $personal_car){
        return $personal_car->delete();
    }

    public function AddMoney(User $user, $amount)
    {
        $user->balance += $amount;
        $user->save();
    }

    public function buyCar(BuyCarRequest $request)
    {
        $data = $request->validated();
//        $user = User::findOrFail($data["user"]);
        $user = User::findOrFail(auth()->id());
        $car = CarModel::findOrFail($data["car"]);

        if ($user->balance < $car->cost) return response()->json(["success" => false, "message" => "У Вас недостаточно средств для покупки данного авто"]);

        $this->AddMoney($user, -$car->cost);
        $this->addCar($user, $car);

        return response()->json([
            "success" => true,
            "message" => "Вы успешно купили автомобиль {$car->brand->name} {$car->name}",
        ]);
    }

    public function sellCar(SellCarRequest $request)
    {
        $data = $request->validated();
        $user = User::findOrFail(auth()->id());
        $personalCar = CarModelUser::findOrFail($data["personal_car_id"]);
        $carModel = CarModel::find($personalCar->car_model_id);

        if ($user->id === $personalCar->user_id) {
            $money = ($carModel->cost);
            $this->AddMoney($user, round($money / 2));
            $this->removeCar($personalCar);
        }
        return response()->json([
            "success" => true,
            "message" => "Вы успешно продали автомобиль {$carModel->brand->name} {$carModel->name}",
            "data" => [
                "new_balance" => $user->balance
            ]
        ]);
    }



}
