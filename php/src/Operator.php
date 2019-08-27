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

    const SIN    = 'sin';
    const COS    = 'cos';
    const TAN    = 'tan';
    const ARCSIN = 'arcsin';
    const ARCCOS = 'arccos';
    const ARCTAN = 'arctan';
    const LOG    = 'log';
    const LN     = 'ln';
    const SQRT   = 'sqrt';
    const ABS    = 'abs';
    const INT    = 'int';

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
        self::INT       => 110,
        self::ABS       => 120,
        self::SQRT      => 130,
        self::LOG       => 140,
        self::LN        => 140,
        self::SIN       => 150,
        self::COS       => 150,
        self::TAN       => 150,
        self::ARCSIN    => 150,
        self::ARCCOS    => 150,
        self::ARCTAN    => 150,
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

    public static function getPatterns(): array {

        $patterns = [];

        foreach( static::VALID as $operator => $precedence ) {
            $patterns[$operator] = sprintf("/^%s/", preg_quote($operator, '/'));
        }

        return $patterns;

    }

    public function getPrecedence(): int {
        return 0;
    }

}
