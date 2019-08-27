<?php

namespace Evaluator;

use InvalidArgumentException;

class Func extends Token {

    const TYPE = self::FUNC;

    const SIN = 'sin';
    const COS = 'cos';
    const TAN = 'tan';
    const ARCSIN = 'arcsin';
    const ARCCOS = 'arccos';
    const ARCTAN = 'arctan';
    const LOG = 'log';
    const LN = 'ln';
    const SQRT = 'sqrt';
    const ABS = 'abs';
    const INT = 'int';

    public function __construct( string $token ) {

        $valid = [
            static::INT    => 110,
            static::ABS    => 120,
            static::SQRT   => 130,
            static::LOG    => 140,
            static::LN     => 140,
            static::SIN    => 150,
            static::COS    => 150,
            static::TAN    => 150,
            static::ARCSIN => 150,
            static::ARCCOS => 150,
            static::ARCTAN => 150,
        ];

        if( !isset($valid[$token]) ) {
            throw new InvalidArgumentException("Unknown function token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isFunction(): bool {
        return true;
    }

    public function isValidChar( string $char ): bool {

        if( preg_match('/[a-z]/i', $char) ) {
            return true;
        }
        return false;

    }

}
