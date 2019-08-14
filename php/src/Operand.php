<?php

namespace Evaluator;

use InvalidArgumentException;

class Operand extends Token {

    public function __construct( string $token ) {

        if( !is_numeric($token) ) {
            throw new InvalidArgumentException("Invalid operand token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isOperand() {
        return true;
    }

}
