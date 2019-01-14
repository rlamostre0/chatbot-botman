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
use Illuminate\Support\Facades\Log;

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
        return $this->responses($question);
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
      return $this->responses($question);
    }
    public function displayProducts(){
      $question = Question::create("Would you like to add these items?")
          ->fallback('Unable to ask question')
          ->callbackId('ask_reason')
          ->addButtons([
              Button::create('Yes')->value('yes'),
              Button::create('No')->value('no'),
          ]);
      return $this->responses($question);
    }
    public function responses($question){
      $menus=new Menus;
      return $this->ask($question, function (Answer $answer) use (&$menus) {
          if ($answer->isInteractiveMessageReply()) {
              $payload=json_decode(json_encode($this->bot->getMessage()->getPayload()),true);
              Log::info($payload);
              if(isset($payload['postback']['payload'])){
                Log::info('passed');
                $menu=$menus->getRestaurantMenu();
                if (strpos($payload['postback']['payload'], 'category') !== false) {
                  $payload=str_replace("category","",$payload['postback']['payload']);
                  $this->say("View ".$menu[intval($payload)]['name']);
                  $this->displayProducts();
                }
              }else{
                if ($answer->getValue() === 'start-order') {
                    $this->say("Select a category below");
                    $this->displayCategories();
                } else if ($answer->getValue() === 'view-orders') {
                  $this->say('Showing your orders in a while');
                  $this->askReason();
                }else{
                  $this->askReason();
                }
              }
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
