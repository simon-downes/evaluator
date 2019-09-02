<?php

namespace Evaluator;

use InvalidArgumentException;

class Token {

    const NONE       = 'none';
    const OPERATOR   = 'operator';
    const OPERAND    = 'operand';
    const WHITESPACE = 'whitespace';

    const NUMBER      = 'number';
    const SPACE       = 'space';
    const ADD         = 'add';
    const SUBTRACT    = 'subtract';
    const MULTIPLY    = 'multiply';
    const DIVIDE      = 'divide';
    const AND         = 'and';
    const OR          = 'or';
    const NOT         = 'not';
    const EQ          = 'eq';
    const LT          = 'lt';
    const LTE         = 'lte';
    const GT          = 'gt';
    const GTE         = 'gte';
    const OPEN_PAREN  = 'open_paren';
    const CLOSE_PAREN = 'close_paren';
    const MODULO      = 'modulo';
    const POWER       = 'power';
    const SIN         = 'sin';
    const COS         = 'cos';
    const TAN         = 'tan';
    const ARCSIN      = 'arcsin';
    const ARCCOS      = 'arccos';
    const ARCTAN      = 'arctan';
    const LOG         = 'log';
    const LN          = 'ln';
    const SQRT        = 'sqrt';
    const ABS         = 'abs';
    const INT         = 'int';

    protected $type;

    protected $name;

    protected $value;

    public function __construct( string $type, string $name, string $value = '' ) {

        if( !in_array($type, [static::NONE, static::OPERATOR, static::OPERAND, static::WHITESPACE]) ) {
            throw new InvalidArgumentException("Unknown token type: {$type}");
        }

        if( empty($name) ) {
            throw new InvalidArgumentException("Tokens must have a name");
        }

        $this->type  = $type;
        $this->name  = $name;
        $this->value = $value;

    }

    public function __get( $key ) {

        if( in_array($key, ['type', 'name', 'value']) ) {
            return $this->$key;
        }

        return null;

    }

    public function isWhitespace(): bool {
        return $this->type == static::WHITESPACE;
    }

    public function isOperator(): bool {
        return $this->type == static::OPERATOR;
    }

    public function isOperand(): bool {
        return $this->type == static::OPERAND;
    }

    public function __toString(): string {
        return "{$this->type}::{$this->name}::{$this->value}";
    }

}
