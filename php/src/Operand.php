<?php

namespace Evaluator;

use InvalidArgumentException;

class Operand extends Token {

    const TYPE = self::OPERAND;

    const NUMBER = 'number';



    public function __construct( string $token ) {

        if( !is_numeric($token) ) {
            throw new InvalidArgumentException("Invalid operand token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isOperand(): bool {
        return true;
    }

    public static function getPatterns(): array {

        return [
            static::NUMBER => '/^((-?[0-9]+\.[0-9]+)|(-?[0-9]+))/',
        ];

    }

}
