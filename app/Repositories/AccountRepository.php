<?php

namespace App\Repositories;

use App\Account;

class AccountRepository
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function findByColumn($column, $value)
    {
        return $this->account->where($column, $value)->get();
    }

    public function insert($attributes)
    {
        return $this->account->insert($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->account->find($id)->update($attributes);
    }
}