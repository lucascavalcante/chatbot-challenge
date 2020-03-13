<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\DefaultCurrencyConversation;

class CurrencyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function setDefault(BotMan $bot)
    {
        $bot->startConversation(new DefaultCurrencyConversation());
    }
}
