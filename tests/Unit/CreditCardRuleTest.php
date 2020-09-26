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

namespace Jlorente\Laravel\CreditCards\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Jlorente\CreditCards\CreditCardValidator;
use Jlorente\Laravel\CreditCards\Rules\CreditCardRule;
use Jlorente\Laravel\CreditCards\Tests\TestCase;

/**
 * Class CreditCardRuleTest.
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class CreditCardRuleTest extends TestCase
{

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidCard()
    {
        $nif = '30569309025904';
        $validator = new CreditCardRule();

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidCard()
    {
        $nif = '30569309025905';
        $validator = new CreditCardRule();

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidCardFormatBecauseMissingDigits()
    {
        $nif = '30569309025';
        $validator = new CreditCardRule();

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidCardFormatBecauseInvalidCharacters()
    {
        $nif = 'B305693C09D0259A';
        $validator = new CreditCardRule();

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidCards()
    {
        $ccs = [
            '371449635398431'
            , '30569309025904'
            , '6011111111111117'
            , '3530111333300000'
            , '5555555555554444'
            , '4111111111111111'
            , '4242424242424242'
        ];

        $validator = new CreditCardRule();

        foreach ($ccs as $cc) {
            $this->assertTrue($validator->passes('credit_card', $cc));
        }
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     * @doesNotPerformAssertions
     */
    public function testValidCardUsingTheValidator()
    {
        Validator::make([
            'card_number' => '4242424242424242'
                ], [
            'card_number' => 'credit_card'
        ])->validate();
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidCardUsingTheValidator()
    {
        $this->expectException(ValidationException::class);

        Validator::make([
            'card_number' => '4242424242424243'
                ], [
            'card_number' => 'credit_card'
        ])->validate();
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     * @doesNotPerformAssertions
     */
    public function testValidCardUsingTheValidatorPassingAllowedTypes()
    {
        Validator::make([
            'card_number' => '4242424242424242'
                ], [
            'card_number' => 'credit_card:visa'
        ])->validate();
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidCardUsingTheValidatorPassingAllowedTypes()
    {
        $this->expectException(ValidationException::class);

        Validator::make([
            'card_number' => '4242424242424242'
                ], [
            'card_number' => 'credit_card:mastercard,american-express'
        ])->validate();
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidVisaCard()
    {
        $nif = '4111111111111111';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_VISA]);

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidVisaCard()
    {
        $nif = '371449635398431';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_VISA]);

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidMastercardCard()
    {
        $nif = '5555555555554444';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_MASTERCARD]);

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidMastercardCard()
    {
        $nif = '5055555555554444';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_MASTERCARD]);

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidAmericanExpressCard()
    {
        $nif = '371449635398431';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_AMERICAN_EXPRESS]);

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidAmericanExpressCard()
    {
        $nif = '331449635398431';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_AMERICAN_EXPRESS]);

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidDiscoverCard()
    {
        $nif = '6011111111111117';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_DISCOVER]);

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidDiscoverCard()
    {
        $nif = '6001111111111117';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_DISCOVER]);

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidJCBCard()
    {
        $nif = '3530111333300000';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_JCB]);

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidJCBCard()
    {
        $nif = '371449635398431';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_JCB]);

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidMaestroCard()
    {
        $nif = '6759929714400199';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_MAESTRO]);

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidMaestroCard()
    {
        $nif = '3530111333300000';
        $validator = new CreditCardRule([CreditCardValidator::TYPE_MAESTRO]);

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testValidVisaCardCvc()
    {
        $nif = '4111111111111111';
        $validator = new CreditCardRule(CreditCardValidator::TYPE_VISA, '213');

        $this->assertTrue($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidVisaCardCvc()
    {
        $nif = '371449635398431';
        $validator = new CreditCardRule(CreditCardValidator::TYPE_VISA, '1234');

        $this->assertFalse($validator->passes('credit_card', $nif));
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     * @doesNotPerformAssertions
     */
    public function testValidVisaCardCvcUsingTheValidator()
    {
        Validator::make([
            'card_number' => '4111111111111111'
                ], [
            'card_number' => 'credit_card:213'
        ])->validate();
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidVisaCardCvcUsingTheValidator()
    {
        $this->expectException(ValidationException::class);

        Validator::make([
            'card_number' => '4111111111111111'
                ], [
            'card_number' => 'credit_card:2134'
        ])->validate();
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     * @doesNotPerformAssertions
     */
    public function testValidVisaCardCvcUsingTheValidatorIncludingTypeVisa()
    {
        Validator::make([
            'card_number' => '4111111111111111'
                ], [
            'card_number' => 'credit_card:213,visa,mastercard,american-express'
        ])->validate();
    }

    /**
     * @group ValidationTests
     * @group ValidationUnitTests
     * @group CreditCardRuleTest
     */
    public function testInvalidVisaCardCvcUsingTheValidatorExludingTypeVisa()
    {
        $this->expectException(ValidationException::class);

        Validator::make([
            'card_number' => '4111111111111111'
                ], [
            'card_number' => 'credit_card:213,mastercard,american-express'
        ])->validate();
    }

}
