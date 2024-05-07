<?php

namespace App\Console\Commands;

use App\Domain\Currency\Services\CurrencyService;
use App\Domain\Weather\Services\OpenWeatherMapService;
use App\Mail\WeatherInfoMail;
use App\Webhook\TelegramHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CurrencyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Currency loader';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = new CurrencyService();
       

        $response = $service->loadCurrency();
       
        if($service->saveCurrencies()){
            $this->info('Currencies loaded successfully!');
            return Command::SUCCESS;
        }
        return Command::FAILURE;
      
       
    }

    
}
