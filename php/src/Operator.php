<?php

namespace Evaluator;

use InvalidArgumentException;

class Operator extends Token {

    const ADD         = '+';
    const SUBTRACT    = '-';
    const MULTIPLY    = '*';
    const DIVIDE      = '/';
    const AND         = '&';
    const OR          = '|';
    const NOT         = '!';
    const EQUAL       = '=';
    const LT_EQUAL    = '<=';
    const GT_EQUAL    = '>=';
    const OPEN_PAREN  = '(';
    const CLOSE_PAREN = ')';
    const MODULO      = '%';
    const POWER       = '^';

    public function __construct( string $token ) {

        $valid = [
            static::ADD => true,
            static::SUBTRACT => true,
            static::MULTIPLY => true,
            static::DIVIDE => true,
            static::AND => true,
            static::OR => true,
            static::NOT => true,
            static::EQUAL => true,
            static::LT_EQUAL => true,
            static::GT_EQUAL => true,
            static::OPEN_PAREN => true,
            static::CLOSE_PAREN => true,
            static::MODULO => true,
            static::POWER => true,
        ];

        if( !isset($valid[$token]) ) {
            throw new InvalidArgumentException("Unknown operator token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isOperator() {
        return true;
    }

}
