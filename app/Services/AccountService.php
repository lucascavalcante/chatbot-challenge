<?php

namespace App\Services;

use App\Helpers\CurrencyConverstionHelper;
use App\Repositories\CurrencyRepository;
use App\Repositories\AccountRepository;
use App\Events\TransactionPerformed;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AccountService
{
    protected $accountRepository;
    protected $currencyRepository;

    /**
     * Create a new AccountService instance
     * 
     * @param AccountRepository $accountRepository Dependency injection from repository layer
     * @param CurrencyRepository $currencyRepository Dependency injection from repository layer
     */
    public function __construct(AccountRepository $accountRepository, CurrencyRepository $currencyRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Apply the business logic to save the transaction (deposit or withdraw)
     * 
     * @param float $valueFrom Value typed by the user to transact
     * @param string $currency Currency typed by the user to transact (if null will be the same from current account)
     * @param string $transaction Transaction to be performed (deposit or with draw)
     * 
     * @return array
     */
    public function save(float $valueFrom, ?string $currency, string $transaction): array
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

                // Dispatching event (logging every transaction performed)
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

    /**
     * Apply the business logic to get current account balance
     * 
     * @return array
     */
    public function accountBalance(): array
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
}