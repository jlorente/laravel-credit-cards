<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Allowed Cards
      |--------------------------------------------------------------------------
      |
      | Leaving it empty will take all the available cards in the PHP Credit Cards
      | package.
      |
      | You can add allowed card type values by using the CreditCardValidator
      | constants
      |
      | e.g.:
      | ```php
      | 'allowed_cards' => [
      |     CreditCardValidator::TYPE_VISA,
      |     CreditCardValidator::TYPE_MASTERCARD,
      |     CreditCardValidator::TYPE_AMERICAN_EXPRESS
      | ];
      | ```
      |
      |
     */
    'allowed_cards' => env('CREDIT_CARDS_ALLOWED_CARDS', null) ? explode(',', env('CREDIT_CARDS_ALLOWED_CARDS')) : [
    ],
];
