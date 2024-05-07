<?php

namespace App\Http\Controllers;

use App\Domain\Weather\Services\OpenWeatherMapService;
use Illuminate\Http\Request;

class OpenWeatherMapController extends Controller
{
    public function currentWeather(Request $request){

        $weather = new OpenWeatherMapService();
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
