Laravel Credit Cards
====================

Laravel integration of the [PHP Credit Cards package](https://github.com/jlorente/php-credit-cards).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

With Composer installed, you can then install the extension using the following commands:

```bash
$ php composer.phar require jlorente/laravel-credit-cards
```

or add 

```json
...
    "require": {
        "jlorente/laravel-credit-cards": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Configuration

1. Register the ServiceProvider in your config/app.php service provider list.

config/app.php
```php
return [
    //other stuff
    'providers' => [
        //other stuff
        \Jlorente\Laravel\CreditCards\CreditCardsServiceProvider::class,
    ];
];
```

2. Add the following facade to the $aliases section.

config/app.php
```php
return [
    //other stuff
    'aliases' => [
        //other stuff
        'PayU' => \Jlorente\Laravel\CreditCards\Facades\CreditCardValidator::class,
    ];
];
```

3. Publish the package configuration file.

```bash
$ php artisan vendor:publish --provider='Jlorente\Laravel\CreditCards\CreditCardsServiceProvider'
```

4. If you want to limit the available credit card types in your system, you can 
use the credit_cards.php configuration file to specify them.

config/credit_cards.php
```php
<?php

use Jlorente\CreditCards\CreditCardValidator;

return [
    'allowed_cards' => [
        CreditCardValidator::TYPE_VISA,
        CreditCardValidator::TYPE_MASTERCARD,
        CreditCardValidator::TYPE_AMERICAN_EXPRESS,
    ],
];
```
or in the env configuration by adding a string with array elements separeted 
by coma.

.env
```
//other configurations
CREDIT_CARDS_ALLOWED_CARDS="visa,mastercard,unionpay"
```

## Usage

### CreditCardValidator Facade

You can access a singleton of the CreditCardValidator class through the facade.
 
```php
CreditCardValidator::isVisa($cardNumber);
CreditCardValidator::isMastercard($cardNumber);
$creditCardConfiguration = CreditCardValidator::getType($cardNumber);
```

To see a complete list of available methods of the package see the 
[PHP Credit Cards documentation](https://github.com/jlorente/php-credit-cards).

### CreditCardRule 

A rule to be use in the laravel validation flow is included in the package. 

You can add the rule by using its string form:
```php
class Request {

    public function rules() {
        return [
            'card' => 'credit_card'
        ];
    }
}

```

or the class form:

```php
class Request {

    public function rules() {
        return [
            'card' => CreditCardRule::make()
        ];
    }
}
```

#### Validating security code format

If you provide an integer value as first argument of the rule, the format of the 
security code (CVC, CVV, etc.) will be validated.

```php
class Request {

    public function rules() {
        return [
            'card' => 'credit_card:651'
        ];
    }
}
```

or

```php
class Request {

    public function rules() {
        return [
            'card' => CreditCardRule::make(null, '651')
        ];
    }
}
```

#### Validating the credit card types

You can also provide a list separed by comas of the accepted credit card types. 
Remember that credit card types should be a subset of the configured system 
available types.

```php
public function rules() {
    return [
        'card' => 'credit_card:' implode(',', [CreditCardValidator::TYPE_VISA, CreditCardValidator::TYPE_MASTERCARD]),
    ];
}
```

or

```php
class Request {

    public function rules() {
        return [
            'card' => CreditCardRule::make([
                CreditCardValidator::TYPE_VISA, 
                CreditCardValidator::TYPE_MASTERCARD,
                CreditCardValidator::TYPE_AMERICAN_EXPRESS,
            ]),
        ];
    }
}
```

You can also combine credit cards types with security code validation:

```php
class Request {

    public function rules() {
        return [
            'card' => 'credit_card:651,' . implode(',', [CreditCardValidator::TYPE_VISA, CreditCardValidator::TYPE_MASTERCARD]),
        ];
    }
}
```

or

```php
class Request {

    public function rules() {
        return [
            'card' => CreditCardRule::make(
                [
                    CreditCardValidator::TYPE_VISA, 
                    CreditCardValidator::TYPE_MASTERCARD,
                    CreditCardValidator::TYPE_AMERICAN_EXPRESS,
                ], 
                '651',
            ),
        ];
    }
}
```

## License 
Copyright &copy; 2020 José Lorente Martín <jose.lorente.martin@gmail.com>.

Licensed under the BSD 3-Clause License. See LICENSE.txt for details.
