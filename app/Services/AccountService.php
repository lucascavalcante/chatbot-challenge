<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Repositories\CurrencyRepository;
use Illuminate\Support\Facades\Auth;

class AccountService
{
    protected $accountRepository;
    protected $currencyRepository;

    public function __construct(AccountRepository $accountRepository, CurrencyRepository $currencyRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function save($value, $currency, $transaction)
    {
        $currencyId = $this->currencyRepository->findByColumn('initials', $currency)[0]->id;
        $account = $this->accountRepository->findByColumn('user_id', Auth::id());
        if(count($account) > 0) {
            $amount = $transaction === 'deposit' ?  ($account[0]->amount += $value) : ($account[0]->amount -= $value);
            $return = $amount >= 0 ? $this->accountRepository->update($account[0]->id, [
                'user_id' => Auth::id(),
                'currency_id' => $currencyId,
                'amount' => $amount
            ]) : false;
        } else {
            $return = false;
        }

        return $return;
    }

    public function accountBalance()
    {
        $account = $this->accountRepository->findByColumn('user_id', Auth::id());
        return [
            'amount' => $account[0]->amount,
            'currency' => $account[0]->currency->initials
        ];
    }
}