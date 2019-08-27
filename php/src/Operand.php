<?php

namespace Evaluator;

use InvalidArgumentException;

class Operand extends Token {

    const TYPE = self::OPERAND;

    public function __construct( string $token ) {

        if( !is_numeric($token) ) {
            throw new InvalidArgumentException("Invalid operand token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isOperand(): bool {
        return true;
    }

    public function isValidChar( string $char ): bool {

        if( preg_match('/[0-9.]/', $char) ) {
            return true;
        }
        return false;

    }

}
