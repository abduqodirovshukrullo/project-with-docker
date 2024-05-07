<?php

namespace App\Http\Controllers;

use App\Domain\Currency\Entities\Currency;
use App\Domain\Weather\Services\AccuWeatherService;
use App\Domain\Currency\Services\CurrencyService;
use App\Http\Resources\Currency\CurrencyCollection;
use App\Http\Resources\Currency\CurrencyResource;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{   
    public $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }



    public function index(Request $request){
        $response = $this->currencyService->getCurrencies($request);
        return $this->respondWithResourceCollection(new CurrencyCollection($response));
    }

    public function show(Currency $currency){
        return $this->respondWithResource(new CurrencyResource($currency));
    }
}
