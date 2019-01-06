<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use App\Helpers\Menus;

class OnboardingConversation extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("What can I do for you?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Start order')->value('start-order'),
                Button::create('View my orders')->value('view-orders'),
            ]);
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'start-order') {
                    // $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->say("Select a category below");
                    $this->displayCategories();
                } else {
                    $this->say('Showing your orders in a while');
                }
            }
        });
    }
    public function displayCategories(){

      $menus=new Menus;
      $menu=$menus->getRestaurantMenu();
      $options=[];
      foreach($menu as $mKey=>$m){
        $options[]=Element::create($m['name'])
            ->subtitle($m['description'])
            ->image('https://dummyimage.com/300')
            ->addButton(ElementButton::create('View Products')
                ->payload('category'.$mKey)
                ->type('postback')
            );
      }
      $question=GenericTemplate::create()
          ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
          ->addElements($options);
      return $this->ask($question, function (Answer $answer) use (&$menu) {
        if ($answer->isInteractiveMessageReply()) {
          $payload=json_decode(json_encode($this->bot->getMessage()->getPayload()),true);
          $payload=str_replace("category","",$payload['postback']['payload']);
          $this->say("View ".$menu[intval($payload)]['name']);
        }
      });
    }
    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
