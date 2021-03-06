<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use App\Services\AccountService;
use BotMan\BotMan\BotMan;

class AccountController extends Controller
{
    protected $accountService;
    protected $currencyService;

    /**
     * Create a new AccountController instance
     * 
     * @param AccountService $accountService Dependency injection from service layer
     * @param CurrencyService $currencyService Dependency injection from service layer
     */
    public function __construct(AccountService $accountService, CurrencyService $currencyService)
    {
        $this->middleware('auth');
        $this->accountService = $accountService;
        $this->currencyService = $currencyService;
    }

    /**
     * Deposit an amount on the account from the logged user
     * 
     * @param Botman\Botman\Botman $bot Botman instance
     * @param string $value Param from bot command on chat
     */
    public function deposit(BotMan $bot, string $value)
    {
        list($number, $currency) = $this->currencyService->checkCurrencyIsNull($value);
        if($this->currencyService->checkValidCurrency($currency) && floatval($number)) {
            $deposit = $this->accountService->save(floatval($number), $currency, 'deposit');
            $bot->reply($deposit['msg']);
        } else {
            $bot->reply("Invalid parameters");
        }
    }

    /**
     * Withdraw an amount from the account from the logged user
     * 
     * @param Botman\Botman\Botman $bot Botman instance
     * @param string $value Param from bot command on chat
     */
    public function withdraw(Botman $bot, string $value)
    {
        list($number, $currency) = $this->currencyService->checkCurrencyIsNull($value);
        if($this->currencyService->checkValidCurrency($currency) && floatval($number)) {
            $withdraw = $this->accountService->save(floatval($number), $currency, 'withdraw');
            $bot->reply($withdraw['msg']);
        } else {
            $bot->reply("Invalid parameters");
        }
    }

    /**
     * List the current account balance from the logged user
     * 
     * @param Botman\Botman\Botman $bot Botman instance
     */
    public function accountBalance(Botman $bot)
    {
        $accountBalance = $this->accountService->accountBalance();
        $bot->reply($accountBalance['msg']);
    }

}
