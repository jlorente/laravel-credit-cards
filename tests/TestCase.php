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

namespace Jlorente\Laravel\CreditCards\Tests;

use Jlorente\Laravel\CreditCards\CreditCardsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    /**
     * @inheritdoc
     */
    protected function getPackageProviders($app)
    {
        return [
            CreditCardsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('credit-cards.allowed_cards', []);
    }
}
