<?php

namespace Evaluator;

use InvalidArgumentException;

class Func extends Token {

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
    const INC = 'inc';

    public function __construct( string $token ) {

        $valid = [
            static::SIN => true,
            static::COS => true,
            static::TAN => true,
            static::ARCSIN => true,
            static::ARCCOS => true,
            static::ARCTAN => true,
            static::LOG => true,
            static::LN => true,
            static::SQRT => true,
            static::ABS => true,
            static::INC => true,
        ];

        if( !isset($valid[$token]) ) {
            throw new InvalidArgumentException("Unknown function token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isFunction() {
        return true;
    }

}
