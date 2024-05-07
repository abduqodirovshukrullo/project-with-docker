<?php

namespace App\Http\Controllers;

use App\Domain\Weather\Services\AccuWeatherService;
use Illuminate\Http\Request;

class AccuWeatherController extends Controller
{

    public function currentWeather(Request $request){

       $weather = new AccuWeatherService();
       $response = $weather->getCurrentWeather(['name'=>$request->name]);
       return $this->apiResponse(
            [
                'success' => true,
                'result' => $response->json(),
                'message'=>'Success'

            ], 200
        );
    }
}
