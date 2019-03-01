<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use App\Conversations\OnboardingConversation;
use App\Helpers\Menus;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new OnboardingConversation());
    }
    public function getProducts(BotMan $bot){
      // $bot->reply('$bot->getMessage()->getPayload()');
      // $menus=new Menus;
      // $menu=$menus->getRestaurantMenu();
      // $payload=str_replace("category","",$bot->getMessage()->getPayload());

      // $bot->reply('Will retrieve available '.$menu['payload'].' items as soon as I can.');
    }
}
