<?php

namespace App\Controller\App;

use App\Domain\City\Model\City;
use App\Controller\Controller;

class CityController extends Controller
{
    public function districts(City $city)
    {
        return response()->json($city->districts);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(City $city)
    {
        return response()->json($city::all());
    }
}
