<?php

namespace App\Http\Controllers;

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
    
    public function deposit($bot, $value, $currency)
    {
        if($this->currencyService->checkValidCurrency($currency) && doubleval($value)) {
            $deposit = $this->accountService->save($value, $currency, 'deposit');
            if($deposit){
                $bot->reply("Deposit done!");
            } else {
                $bot->reply("Something went wrong.");
            }
        } else {
            $bot->reply("Invalid parameters");
        }
    }

    public function withdraw($bot, $value, $currency)
    {
        if($this->currencyService->checkValidCurrency($currency) && doubleval($value)) {
            $withdraw = $this->accountService->save($value, $currency, 'withdraw');
            if($withdraw){
                $bot->reply("Withdraw done!");
            } else {
                $bot->reply("Something went wrong.");
            }
        } else {
            $bot->reply("Invalid parameters");
        }
    }

    public function accountBalance($bot)
    {
        $accountBalance = $this->accountService->accountBalance();
        $bot->reply("Your current account balance is {$accountBalance['amount']} {$accountBalance['currency']}");
    }

}
