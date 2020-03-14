<?php

namespace App\Services;

use App\Currency;
use App\Repositories\AccountRepository;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyService
{
	protected $currencyRepository;
	protected $accountRepository;

    public function __construct(CurrencyRepository $currencyRepository, AccountRepository $accountRepository)
    {
		$this->currencyRepository = $currencyRepository;
		$this->accountRepository = $accountRepository;
	}

	public function getAll()
	{
		return $this->currencyRepository->all();
	}
	
	public function checkValidCurrency($currency)
	{
		$currencies = $this->currencyRepository->getNameAndInitials();
		foreach($currencies as $c) {
			if($c['initials'] === strtoupper($currency))
				return true;
		}

		return false;
	}

	public function save($currency)
	{
		$currencyId = $this->currencyRepository->findByColumn('initials', $currency)[0]->id;
		$account = $this->accountRepository->findByColumn('user_id', Auth::id());
		if(count($account) > 0) {
			$return = [
				'status' => $this->accountRepository->update($account[0]->id, [
					'user_id' => Auth::id(),
					'currency_id' => $currencyId,
					'amount' => $account[0]->amount
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

    // public function create(Request $request)
	// {
    //     $attributes = $request->all();
         
    //     return $this->currency->create($attributes);
	// }
}