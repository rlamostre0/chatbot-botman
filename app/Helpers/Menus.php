<?php

namespace App\Helpers;

class Menus
{
    public function getRestaurantMenu(){
      return [
        [
          'id' => 1,
          'name' => 'Appetizers',
          'description' => 'small dish served before a meal. Some hors d\'oeuvres are served cold, others hot. Hors d\'oeuvres may be served at the dinner table as a part of the meal, or they may be served before seating. Formerly, hors d\'oeuvres were also served between courses. ',
          'products' => []
        ],
        [
          'id' => 2,
          'name' => 'Salads',
          'description' => 'consisting of a mixture of small pieces of food, usually vegetables. However, different varieties of salad may contain virtually any type of ready-to-eat food. Salads are typically served at room temperature or chilled, with notable exceptions such as south German potato salad which is served warm.',
          'products' => []
        ],
        [
          'id' => 3,
          'name' => 'Entrées',
          'description' =>'in modern French table service and that of much of the English-speaking world is a dish served before the main course of a meal. Outside of North America it is generally synonymous with the terms hors d\'oeuvre, appetizer or starter.',
          'products' => []
        ],
        [
          'id' => 4,
          'name' => 'Side Items',
          'description' =>'accompanies the entrée or main course at a meal',
          'products' => []
        ],
        [
          'id' => 5,
          'name' => 'Beverages',
          'description' =>'drinks include plain drinking water, milk, coffee, tea, hot chocolate and soft drinks.',
          'products' => []
        ],
      ];
    }
}
