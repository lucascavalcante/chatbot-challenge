<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use BotMan\BotMan\BotMan;

class CurrencyController extends Controller
{
    protected $currencyService;

    /**
     * Create a new CurrencyController instance
     * 
     * @param CurrencyService $currencyService Dependency injection from service layer
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->middleware('auth');
        $this->currencyService = $currencyService;
    }

    /**
     * List all available currencies into the application
     * 
     * @param Botman\Botman\Botman $bot Botman instance
     */
    public function availableCurrencies(BotMan $bot)
    {
        $currencies = $this->currencyService->getAll();
        foreach($currencies as $c) {
            $bot->reply($c['initials']." (".$c['name'].")");
        }
    }
    
    /**
     * Set a currency as default for the logged user and create a new account (if doesn't exist)
     * 
     * @param Botman\Botman\Botman $bot Botman instance
     * @param string $currency Param from bot command on chat
     */
    public function setDefault(Botman $bot, string $currency)
    {
        $currency = strtoupper($currency);
        if($this->currencyService->checkValidCurrency($currency)) {
            $setCurrency = $this->currencyService->save($currency);
            $bot->reply($setCurrency['msg']);
        } else {
            $bot->reply("Invalid parameters");
        }
    }
}
