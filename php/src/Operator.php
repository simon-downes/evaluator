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
    const LT          = '<';
    const LT_EQUAL    = '<=';
    const GT          = '>';
    const GT_EQUAL    = '>=';
    const OPEN_PAREN  = '(';
    const CLOSE_PAREN = ')';
    const MODULO      = '%';
    const POWER       = '^';

    const VALID = [
        self::ADD => true,
        self::SUBTRACT => true,
        self::MULTIPLY => true,
        self::DIVIDE => true,
        self::AND => true,
        self::OR => true,
        self::NOT => true,
        self::EQUAL => true,
        self::LT => true,
        self::LT_EQUAL => true,
        self::GT => true,
        self::GT_EQUAL => true,
        self::OPEN_PAREN => true,
        self::CLOSE_PAREN => true,
        self::MODULO => true,
        self::POWER => true,
    ];

    public function __construct( string $token ) {

        if( !isset(static::VALID[$token]) ) {
            throw new InvalidArgumentException("Unknown operator token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isOperator(): bool {
        return true;
    }

    public function isValidChar( string $char ): bool {
        return isset(static::VALID[$char]);
    }

}
