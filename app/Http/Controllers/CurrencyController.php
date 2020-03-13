<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\DefaultCurrencyConversation;

class CurrencyController extends Controller
{
    public function setDefault(BotMan $bot)
    {
        $bot->startConversation(new DefaultCurrencyConversation());
    }
}
