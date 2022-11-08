<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roulette\CreateRequest;
use App\Http\Resources\CarModel\CarModelResource;
use App\Http\Resources\Roulette\RouletteCollection;
use App\Http\Resources\Roulette\RouletteResource;
use App\Http\Resources\User\UserResource;
use App\Models\Roulette;
use App\Models\User;
use Illuminate\Http\Request;

class RouletteController extends Controller
{
    const EXPENSIVE_CAR_CHANCE  =   0.25;
    const COMMON_CAR_CHANCE     =   1 - self::EXPENSIVE_CAR_CHANCE;

    /**
     * @return RouletteCollection
     */
    public function all()
    {
        return new RouletteCollection(Roulette::all());
    }

    /**
     * @param int $id
     * @return RouletteResource
     */
    public function byId(int $id): RouletteResource
    {
        return new RouletteResource(Roulette::findOrFail($id));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function open(int $id)
    {
        if (!$user = auth()->user()) return response()->json(["success"=>false, "message" => "Вы не авторризованы"],401);

        if(!$user = User::find($user['id'])) return response()->json(["success" => false, "message" => "Аккаунт не существует"], 401);

        $roulette = Roulette::findOrFail($id);

        if($user->balance < $roulette->price) return response()->json(["success" => false, "message" => "У вас недостаточно средств"], 403);

        $chances = $this->getChances($roulette);
        $random_item_index = $this->getRandomItem($chances);

        $user->cars()->attach($roulette->cars[$random_item_index]);
        $user->balance -= $roulette->price;
        $user->save();

        return response()->json([
            "success" => true,
            "data" => [
                'chance' => $chances[$random_item_index],
                'chances' => $chances,
                'item' => new CarModelResource($roulette->cars[$random_item_index]),
                'user' => new UserResource($user)
            ],
        ]);

    }

    /**
     * @param CreateRequest $request
     * @return RouletteResource
     */
    public function create(CreateRequest $request)
    {
        $data = $request->validated();
        $roulette = Roulette::query()->firstOrCreate(
            [
                "name" => $data["name"]
            ],
            [
                "price" => $data["price"]
            ]
        );

        $roulette->price = $data["price"];
        $roulette->cars()->sync($data["cars"]);
        $roulette->save();
        return new RouletteResource($roulette);
    }



    /**
     * @param array $chances
     * @return int
     */
    public function getRandomItem(array $chances): int {
        $random_number = rand(1, 99) / 100;
        $max = 0;
        $random_item_index = 0;
        foreach ($chances as $index => $chance) {
            $min = $max;
            $max += $chance;
            if ($random_number > $min && $random_number <= $max) $random_item_index = $index;
        }
        return $random_item_index;
    }

    /**
     * @param Roulette $roulette
     * @return array
     */
    public function getExpensiveCars(Roulette $roulette): array {
        $expensive_cars = [];
        foreach ($roulette->cars as $car) {
            if ($car->cost > $roulette->price) {
                $expensive_cars[] = $car;
            }
        }
        return $expensive_cars;
    }

    /**
     * @param Roulette $roulette
     * @return array
     */
    public function getChances(Roulette $roulette): array {
        $chances = [];
        $expensive_cars = $this->getExpensiveCars($roulette);
        $under_chance = 1;
        foreach ($roulette->cars as $car) {
            if (in_array($car, $expensive_cars)) {
                $chance = self::EXPENSIVE_CAR_CHANCE / count($expensive_cars);
                $chances[] = $chance;
                $under_chance -= $chance;
            } else {
                $chance = self::COMMON_CAR_CHANCE / ($roulette->cars->count() - count($expensive_cars));
                $chances[] = $chance;
                $under_chance -= $chance;
            }
        }
        if ($under_chance > 0) {
            $per_car_adding_chance = $under_chance / $roulette->cars->count();
            foreach ($roulette->cars as $index => $car){
                $chances[$index] += $per_car_adding_chance;
                $under_chance -= $per_car_adding_chance;
            }
        }
        return $chances;
    }
}
