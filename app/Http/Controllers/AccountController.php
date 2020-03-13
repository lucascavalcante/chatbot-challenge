<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function deposit($bot, $value, $currency)
    {
        $bot->reply("You deposited {$currency} {$value}");
    }

    public function withdraw($bot, $value, $currency)
    {
        $bot->reply("You withdrew {$currency} {$value}");
    }

    public function accountBalance($bot)
    {
        $bot->reply("Your account balance is 100 dollars");
    }

}
