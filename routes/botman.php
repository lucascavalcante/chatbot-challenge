<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Auth;

$botman = resolve('botman');

$botman->hears('Hi|Hello|Hey', function ($bot) {
    $bot->reply("Hello ".Auth::user()['name']."! My name is Botman and I will help you with the transactions.");
});

$botman->hears('Available currencies', 'App\Http\Controllers\CurrencyController@availableCurrencies');
$botman->hears('Set default currency {currency}', 'App\Http\Controllers\CurrencyController@setDefault');
$botman->hears('Deposit {value}', 'App\Http\Controllers\AccountController@deposit');
$botman->hears('Withdraw {value}', 'App\Http\Controllers\AccountController@withdraw');
$botman->hears('Show account balance', 'App\Http\Controllers\AccountController@accountBalance');

$botman->fallback(function($bot) {
    $bot->reply("Unknown command.");
});
