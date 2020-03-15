<?php

namespace App\Repositories;

use App\Currency;

class CurrencyRepository extends BaseRepository
{
    protected $currency;

    /**
     * Create a new CurrencyRepository instance
     * 
     * @param Currency $currency Dependency injection from model layer
     */
    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
        parent::__construct($currency);
    }

    /**
     * Get all ocurrencies from currencies table, but only name and initials columns
     * 
     * @return array
     */
    public function getNameAndInitials(): array
    {
        return $this->currency::get(['name', 'initials'])->toArray();
    }
}