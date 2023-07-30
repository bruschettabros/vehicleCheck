<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VehicleController extends Controller
{
    public function get(VehicleRequest $request): AnonymousResourceCollection
    {
        $vehicles = Vehicle::where(static function ($query) use ($request) {
            $query->MakeLike($request->input('make'))
                ->ModelLike($request->input('model'))
                ->RegistrationLike($request->input('registration'));
        })->orWhereNull('id');

        return VehicleResource::collection($vehicles->get());
    }
}
