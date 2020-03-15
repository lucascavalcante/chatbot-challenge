<?php

namespace App\Repositories;

use App\Account;

class AccountRepository extends BaseRepository
{
    protected $account;

    /**
     * Create a new AccountRepository instance
     * 
     * @param Account $account Dependency injection from model layer
     */
    public function __construct(Account $account)
    {
        parent::__construct($account);
    }
}