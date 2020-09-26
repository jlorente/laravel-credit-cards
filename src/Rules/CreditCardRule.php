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

namespace Jlorente\Laravel\CreditCards\Rules;

use Illuminate\Contracts\Validation\Rule;
use Jlorente\CreditCards\CreditCardValidator;

/**
 * Class CreditCardRule.
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class CreditCardRule implements Rule
{

    /**
     * The type of the card to validate.
     * 
     * @var boolean
     */
    protected $types = null;

    /**
     * The type of the card to validate.
     * 
     * @var boolean
     */
    protected $securityCode = null;

    /**
     * CreditCardRule constructor.
     * 
     * @param string|null|array $types
     * @param string|null $securityCode
     */
    public function __construct($types = null, $securityCode = null)
    {
        $this->types = (array) $types;
        $this->securityCode = $securityCode;
    }

    /**
     * CreditCardRule static constructor.
     * 
     * @param string|null|array $types
     * @param string|null $securityCode
     */
    public static function make($types = null, $securityCode = null): CreditCardRule
    {
        return new static($types, $securityCode);
    }

    /**
     * @inheritdoc
     */
    public function passes($attribute, $value)
    {
        $cardNumber = (string) $value;

        $cardTypeConfig = app(CreditCardValidator::class)->getType($cardNumber);

        if (!$cardTypeConfig) {
            return false;
        }

        if ($this->types) {
            $result = false;
            foreach ($this->types as $type) {
                if ($type === $cardTypeConfig->getType()) {
                    $result = true;
                    break;
                }
            }

            if ($result === false) {
                return false;
            }
        }

        if ($this->securityCode && $cardTypeConfig->matchesSecurityCode($this->securityCode) === false) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function message()
    {
        if ($this->securityCode) {
            return __('credit_cards::validation.credit_card_rule_with_security_code_failed');
        } else {
            return __('credit_cards::validation.credit_card_rule_failed');
        }
    }

}
