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

    public function create($attributes)
    {
        return $this->currency->create($attributes);
    }
  
    public function find($id)
    {
        return $this->currency->find($id);
    }

    public function update($id, $attributes)
    {
        return $this->currency->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->currency->find($id)->delete();
    }
}