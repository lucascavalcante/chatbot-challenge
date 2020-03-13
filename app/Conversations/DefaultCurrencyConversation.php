<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class DefaultCurrencyConversation extends Conversation
{
    private function setDefault()
    {
        $question = Question::create("Please, select which currency will be the default on your account.")
            ->fallback('Invalid option')
            ->callbackId('set_default_currency')
            ->addButtons([
                Button::create('USD')->value('usd'),
                Button::create('EUR')->value('eur'),
                Button::create('GBP')->value('gbp'),
                Button::create('BRL')->value('brl')
            ]);

        return $this->ask($question, function (Answer $answer){
            if($answer->isInteractiveMessageReply()) {
                switch($answer->getValue()) {
                    case 'usd':
                        $this->say('foi dollar');
                    break;
                    case 'eur':
                        $this->say('foi euro');
                    break;
                    case 'gbp':
                        $this->say('foi pounds');
                    break;
                    case 'brl':
                        $this->say('foi real');
                    break;
                }
            }
        });
    }

    public function run()
    {
        $this->setDefault();
    }
}