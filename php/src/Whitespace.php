<?php

namespace Evaluator;

use InvalidArgumentException;

class Whitespace extends Token {

    const TYPE = self::WHITESPACE;

    const SPACE           = ' ';
    const TAB             = "\t";
    const NEW_LINE        = "\n";
    const CARRIAGE_RETURN = "\r";

    const VALID = [
        self::SPACE => true,
        self::TAB => true,
        self::NEW_LINE => true,
        self::CARRIAGE_RETURN => true,
    ];

    public function __construct( string $token ) {

        if( !isset(static::VALID[$token]) ) {
            throw new InvalidArgumentException("Unknown whitespace token: '{$token}'");
        }

        parent::__construct($token);

    }

    public function isWhitespace(): bool {
        return true;
    }

    public function isValidChar( string $char ): bool {
        return isset(static::VALID[$char]);
    }

}
