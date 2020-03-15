<?php

namespace App\Services;

use App\Helpers\CurrencyConverstionHelper;
use App\Repositories\AccountRepository;
use App\Repositories\CurrencyRepository;
use Illuminate\Support\Facades\Auth;

class CurrencyService
{
	protected $currencyRepository;
	protected $accountRepository;

	/**
     * Create a new CurrencyService instance
     * 
     * @param CurrencyRepository $currencyRepository Dependency injection from repository layer
     * @param AccountRepository $accountRepository Dependency injection from repository layer
     */
    public function __construct(CurrencyRepository $currencyRepository, AccountRepository $accountRepository)
    {
		$this->currencyRepository = $currencyRepository;
		$this->accountRepository = $accountRepository;
	}

	/**
	 * Get all currencies available
	 * 
	 * @return object
	 */
	public function getAll(): object
	{
		return $this->currencyRepository->all();
	}
	
	/**
	 * Check if the currency typed by the user is among the options available
	 * 
	 * @param string $currency Currency typed by the user to set as default
	 * (if null will be the same from current account / if account doesn't exist operation will be not allowed)
	 * 
	 * @return bool
	 */
	public function checkValidCurrency(?string $currency = null): bool
	{
		if($currency === null) {
			$account = $this->accountRepository->findByColumn('user_id', Auth::id());
			if(count($account) > 0) {
				$currency = $this->currencyRepository->find($account[0]->currency_id)->initials;
			} else {
				return false;
			}
		}

		$currencies = $this->currencyRepository->getNameAndInitials();
		foreach($currencies as $c) {
			if($c['initials'] === $currency)
				return true;
		}

		return false;
	}

	/**
	 * Save the currency typed by the user as default into the account (if account doesn't exist, it will be created)
	 * 
	 * @param string $currency Currency typed by the user
	 * 
	 * @return array
	 */
	public function save(string $currency): array
	{
		$currencyId = $this->currencyRepository->findByColumn('initials', $currency)[0]->id;
		$account = $this->accountRepository->findByColumn('user_id', Auth::id());
		if(count($account) > 0) {
			$currentCurrency = $this->currencyRepository->find($account[0]->currency_id);

			$value = strtoupper($currency) !== $currentCurrency->initials ? 
                CurrencyConverstionHelper::convert($currentCurrency->initials, $currency, $account[0]->amount) : 
				$account[0]->amount;
				
			$return = [
				'status' => $this->accountRepository->update($account[0]->id, [
					'user_id' => Auth::id(),
					'currency_id' => $currencyId,
					'amount' => round($value, 2)
				]),
				'msg' => 'Currency updated.'
			];
		} else {
			$return = [
				'status' => $this->accountRepository->insert([
					'user_id' => Auth::id(),
					'currency_id' => $currencyId,
					'amount' => 0
				]),
				'msg' => 'Currency set up.'
			];
		}

		return $return;

	}
}