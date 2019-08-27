<?php

namespace Evaluator;

use InvalidArgumentException;

class Operator extends Token {

    const TYPE = self::OPERATOR;

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
        self::OR          => 20,
        self::AND         => 30,
        self::NOT         => 40,
        self::EQUAL       => 50,
        self::LT          => 50,
        self::LT_EQUAL    => 50,
        self::GT          => 50,
        self::GT_EQUAL    => 50,
        self::OPEN_PAREN  => 60,
        self::CLOSE_PAREN => 70,
        self::ADD         => 70,
        self::SUBTRACT    => 70,
        self::MODULO      => 80,
        self::MULTIPLY    => 90,
        self::DIVIDE      => 90,
        self::POWER       => 100,
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

    public function getPrecedence(): int {
        return 0;
    }

}
