<?php

namespace App\Services;

use App\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class CurrencyService
{
    protected $currency;

    public function __construct(CurrencyRepository $currency)
    {
        $this->currency = $currency;
	}
	
	public function checkValidCurrency($currency)
	{
		$currencies = $this->currency->getNameAndInitials();
		foreach($currencies as $c) {
			if($c['initials'] === strtoupper($currency))
				return true;
		}

		return false;
	}

    // public function index()
	// {
	// 	return $this->currency->all();
	// }
 
    // public function create(Request $request)
	// {
    //     $attributes = $request->all();
         
    //     return $this->currency->create($attributes);
	// }
 
	// public function find($id)
	// {
    //     return $this->currency->find($id);
	// }
 
	// public function update(Request $request, $id)
	// {
    //     $attributes = $request->all();
	  
    //     return $this->currency->update($id, $attributes);
	// }
 
	// public function delete($id)
	// {
    //     return $this->currency->delete($id);
	// }
}