<?php

use App\Http\Controllers\CurrencyController;

$botman = resolve('botman');

$botman->hears('Hi|Hello|Hey', function ($bot) {
    $bot->reply('Hello! My name is Botman and I will help you with the transactions.');
});

$botman->hears('Set default currency', CurrencyController::class.'@setDefault');
$botman->hears('Deposit {value} {currency}', 'App\Http\Controllers\AccountController@deposit');
$botman->hears('Withdraw {value} {currency}', 'App\Http\Controllers\AccountController@withdraw');
$botman->hears('Show account balance', 'App\Http\Controllers\AccountController@accountBalance');

$botman->fallback(function($bot) {
    $bot->reply("Unknown command.");
});
