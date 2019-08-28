<?php

namespace Evaluator;

abstract class Token {

    const NONE       = 'none';
    const OPERATOR   = 'operator';
    const OPERAND    = 'operand';
    const WHITESPACE = 'whitespace';

    const TYPE = self::NONE;

    protected $token;

    public function __construct( string $token ) {
        $this->token = $token;
    }

    public static function fromString( string $type, string $token ) {

        switch( $type ) {

            case static::OPERATOR:
                return new Operator($token);

            case static::OPERAND:
                return new Operand($token);

            case static::WHITESPACE:
                return new Whitespace($token);

        }

        print_r("Nope: $type");

    }

    public function getType(): string {
        return static::TYPE;
    }

    public function isOperator(): bool {
        return false;
    }

    public function isOperand(): bool {
        return false;
    }

    public function getPrecedence(): int {
        return 0;
    }

    public function __toString(): string {
        return $this->token;
    }

}
