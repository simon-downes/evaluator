<?php

namespace Evaluator;

abstract class Token {

    const NONE       = 'none';
    const WHITESPACE = 'whitespace';
    const OPERATOR   = 'operator';
    const OPERAND    = 'operand';
    const FUNC       = 'function';

    protected $token;

    public function __construct( string $token ) {
        $this->token = $token;
    }

    public static function fromString( string $type, string $token ) {

        switch( $type ) {
            case static::WHITESPACE:
                return new Whitespace($token);

            case static::OPERATOR:
                return new Operator($token);

            case static::OPERAND:
                return new Operand($token);

            case static::FUNC:
                return new Func($token);

        }

    }

    public function isOperator(): bool {
        return false;
    }

    public function isOperand(): bool {
        return false;
    }

    public function isFunction(): bool {
        return false;
    }

    public function isValidChar( string $char ): bool {
        return false;
    }

}
