<?php

namespace App\Http\Controllers;

use App\Helpers\CurrencyConverstionHelper;
use App\Services\AccountService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;
    protected $currencyService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AccountService $accountService, CurrencyService $currencyService)
    {
        $this->middleware('auth');
        $this->accountService = $accountService;
        $this->currencyService = $currencyService;
    }

    public function deposit($bot, $value)
    {
        $array = explode(' ', $value);
        $value = $array[0];
        $currency = count($array) > 1 ? strtoupper($array[1]) : null;

        if($this->currencyService->checkValidCurrency($currency) && doubleval($value)) {
            $deposit = $this->accountService->save($value, $currency, 'deposit');
            $bot->reply($deposit['msg']);
        } else {
            $bot->reply("Invalid parameters");
        }
    }

    public function withdraw($bot, $value)
    {
        $array = explode(' ', $value);
        $value = $array[0];
        $currency = count($array) > 1 ? strtoupper($array[1]) : null;
        
        if($this->currencyService->checkValidCurrency($currency) && doubleval($value)) {
            $withdraw = $this->accountService->save($value, $currency, 'withdraw');
            $bot->reply($withdraw['msg']);
        } else {
            $bot->reply("Invalid parameters");
        }
    }

    public function accountBalance($bot)
    {
        $accountBalance = $this->accountService->accountBalance();
        $bot->reply($accountBalance['msg']);
    }

}
