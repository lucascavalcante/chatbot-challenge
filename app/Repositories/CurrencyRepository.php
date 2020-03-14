<?php

namespace App\Repositories;

use App\Currency;

class CurrencyRepository
{
    protected $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function all()
    {
        return $this->currency->all();
    }

    public function getNameAndInitials()
    {
        return $this->currency::get(['name', 'initials'])->toArray();
    }

    public function find($id)
    {
        return $this->currency->find($id);
    }

    public function findByColumn($column, $value)
    {
        return $this->currency->where($column, $value)->get();
    }

    // public function delete($id)
    // {
    //     return $this->currency->find($id)->delete();
    // }
}