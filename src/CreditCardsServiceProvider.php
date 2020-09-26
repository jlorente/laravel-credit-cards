<?php

/**
 * Part of the Laravel Credit Cards package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Laravel Credit Cards
 * @version    7.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente
 */

namespace Jlorente\Laravel\CreditCards;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Jlorente\CreditCards\CreditCardValidator;
use Jlorente\Laravel\CreditCards\Rules\CreditCardRule;

/**
 * Class CreditCardsServiceProvider.
 * 
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class CreditCardsServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * @inheritdoc
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang', 'credit_cards');

        $this->publishes([
            __DIR__ . '/config/credit-cards.php' => config_path('credit-cards.php'),
        ]);

        Validator::extend('credit_card', function ($attribute, $value, $parameters, $validator) {
            $securityCode = null;
            if (isset($parameters[0]) && ctype_digit($parameters[0])) {
                $securityCode = $parameters[0];
                array_shift($parameters);
            }

            return CreditCardRule::make($parameters, $securityCode)->passes($attribute, $value);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerCreditCards();
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            'credit_card_validator'
            , CreditCardValidator::class
        ];
    }

    /**
     * Register the PayU API class.
     *
     * @return void
     */
    protected function registerCreditCards()
    {
        $this->app->singleton('credit_card_validator', function ($app) {
            $config = $app['config']->get('credit-cards');
            return new CreditCardValidator($config['allowed_cards']);
        });

        $this->app->alias('credit_card_validator', CreditCardValidator::class);
    }

}
