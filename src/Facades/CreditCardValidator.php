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
 * @copyright  (c) 2020, Jose Lorente
 */

namespace Jlorente\Laravel\CreditCards\Facades;

use Illuminate\Support\Facades\Facade;
use Jlorente\CreditCards\CreditCardTypeConfig;

/**
 * @method static CreditCardTypeConfig|null getType(string $cardNumber)
 * @method static CreditCardTypeConfig[] getTypesInfo()
 * @method static bool isValid(string $cardNumber)
 * @method static bool is(string $cardType, string $cardNumber)
 * @method static array getAllowedTypesList()
 *
 * @method static bool isVisa(string $cardNumber)
 * @method static bool isMastercard(string $cardNumber)
 * @method static bool isAmericanExpress(string $cardNumber)
 * @method static bool isDinersClub(string $cardNumber)
 * @method static bool isDiscover(string $cardNumber)
 * @method static bool isJCB(string $cardNumber)
 * @method static bool isUnionPay(string $cardNumber)
 * @method static bool isMaestro(string $cardNumber)
 * @method static bool isElo(string $cardNumber)
 * @method static bool isMir(string $cardNumber)
 * @method static bool isHiper(string $cardNumber)
 * @method static bool isHiperCard(string $cardNumber)
 */
class CreditCardValidator extends Facade
{

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'credit_card_validator';
    }

}
