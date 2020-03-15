<?php

namespace App\Repositories;

use App\Account;

class AccountRepository
{
    protected $account;

    /**
     * Create a new AccountRepository instance
     * 
     * @param Account $account Dependency injection from model layer
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Find a ocurrency on accounts table by the column informed
     * 
     * @param string $column Column to be searched
     * @param mixed $value Searched value
     * 
     * @return object
     */
    public function findByColumn(string $column, $value): object
    {
        return $this->account->where($column, $value)->get();
    }

    /**
     * Insert a new register on accounts table
     * 
     * @param array $attributes Values to be save
     * 
     * @return bool
     */
    public function insert(array $attributes): bool
    {
        return $this->account->insert($attributes);
    }

    /**
     * Update a register on accounts table
     * 
     * @param int $id Id from the register to be save
     * @param array $attributes Values to be save
     * 
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        return $this->account->find($id)->update($attributes);
    }
}