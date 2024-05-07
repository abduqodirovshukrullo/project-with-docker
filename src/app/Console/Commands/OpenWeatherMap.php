<?php

namespace App\Console\Commands;

use App\Domain\Weather\Services\OpenWeatherMapService;
use App\Mail\WeatherInfoMail;
use App\Webhook\TelegramHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class OpenWeatherMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:open-weather-map {city} {channel=console} {identifier?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open weather map';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = new OpenWeatherMapService();
        $channel = preg_replace("/[^a-z]/", '', $this->argument('channel'));

        $response = $service->getCurrentWeather(['name'=>$this->argument('city')]);
        $this->info("Weather: {$response->body()}!");
        $this->info($this->argument('channel'));
        if($channel=='telegram'){
            if(empty($this->argument('identifier'))){
                $this->error("Please, write chat id!");
                exit;
            }
            TelegramHandler::deliverNotify(['chat_id'=>$this->argument('identifier'),'text'=>$service->generateTextMessage()]);
        }
        if($channel=='mail'){
            Mail::to($this->argument('identifier'))->send(new WeatherInfoMail($service->generateTextMessage()));
        }
        return Command::SUCCESS;
    }

    
}
