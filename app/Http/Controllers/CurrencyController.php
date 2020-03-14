<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\DefaultCurrencyConversation;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    protected $currencyService;
    
    public function __construct(CurrencyService $currencyService)
    {
        $this->middleware('auth');
        $this->currencyService = $currencyService;
    }

    public function availableCurrencies($bot)
    {
        $currencies = $this->currencyService->getAll();
        foreach($currencies as $c) {
            $bot->reply($c['initials']." (".$c['name'].")");
        }
    }
    
    public function setDefault($bot, $currency)
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
