<?php

namespace App\Services;

use App\Events\TransactionPerformed;
use App\Helpers\CurrencyConverstionHelper;
use App\Repositories\AccountRepository;
use App\Repositories\CurrencyRepository;
use Carbon\Carbon;
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

    public function save($valueFrom, $currency, $transaction)
    {
        $account = $this->accountRepository->findByColumn('user_id', Auth::id());
        if(count($account) > 0) {
            $currentCurrency = $this->currencyRepository->find($account[0]->currency_id);
            
            $valueTo = $currency !== null ? 
                CurrencyConverstionHelper::convert($currency, $currentCurrency->initials, $valueFrom) : 
                $valueFrom;

            $amount = $transaction === 'deposit' ?  ($account[0]->amount += $valueTo) : ($account[0]->amount -= $valueTo);
            if($amount >= 0) {
                $return = [
                    'status' => $this->accountRepository->update($account[0]->id, [
                        'amount' => round($amount, 2)
                    ]),
                    'msg' => ucfirst($transaction).' done!'
                ];

                // Dispatching event (log every transaction performed)
                event(new TransactionPerformed([
                    'operation' => $transaction,
                    'user_id' => Auth::id(),
                    'currency_from' => $currency !== null ? $currency : $currentCurrency->initials,
                    'value_from' => $valueFrom,
                    'currency_to' => $currentCurrency->initials,
                    'value_to' => $valueTo,
                    'created_at' => Carbon::now()
                ]));
            } else {
                $return = [
                    'status' => false,
                    'msg' => 'Insufficient funds'
                ];
            }

        } else {
            $return = [
                'status' => false,
                'msg' => 'Please, set a default currency first.'
            ];
        }
        
        return $return;
    }

    public function accountBalance()
    {
        $account = $this->accountRepository->findByColumn('user_id', Auth::id());
        if(count($account) > 0) {
            $return = [
                'status' => true,
                'msg' => "Your current account balance is {$account[0]->amount} {$account[0]->currency->initials}"
            ];
        } else {
            $return = [
                'status' => false,
                'msg' => 'Please, first set a default currency.'
            ];
        }

        return $return;
    }

    public function upperCurrency($currency = null)
    {
        return $currency ? strtoupper($currency) : null;
    }
}