<?php

namespace App\Controller\App;

use App\Domain\City\Model\State;
use App\Controller\Controller;

class StateController extends Controller
{
    public function cities(State $state)
    {
        return response()->json($state->cities);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(State $state)
    {
        return response()->json($state::all());
    }
}
