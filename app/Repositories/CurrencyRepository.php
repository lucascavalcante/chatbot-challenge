<?php

namespace App\Repositories;

use App\Currency;

class CurrencyRepository
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
    }

    /**
     * Get all ocurrencies from currencies table
     * 
     * @return object
     */
    public function all(): object
    {
        return $this->currency->all();
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

    /**
     * Find a ocurrency on currencies table by id
     * 
     * @param int $id Searched id
     * 
     * @return object
     */
    public function find(int $id): object
    {
        return $this->currency->find($id);
    }

    /**
     * Find a ocurrency on currencies table by the column informed
     * 
     * @param string $column Column to be searched
     * @param mixed $value Searched value
     * 
     * @return object
     */
    public function findByColumn(string $column, $value): object
    {
        return $this->currency->where($column, $value)->get();
    }
}