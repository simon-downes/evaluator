<?php

namespace Evaluator;

abstract class Token {

    protected $token;

    public function __construct( string $token ) {
        $this->token = $token;
    }

    public function isOperator() {
        return false;
    }

    public function isOperand() {
        return false;
    }

    public function isFunction() {
        return false;
    }

}
