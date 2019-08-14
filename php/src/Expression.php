<?php

namespace Evaluator;

class Expression {

    protected $expr;

    protected $tokens;

    public function __construct( string $expr ) {

        $this->expr = $expr;

        $this->tokenise();

    }

    public function evaluate(): string {

        return $this->expr;

    }

    protected function tokenise(): void {

        // convert string to tokens
        $t = new Operand('-123.45');
        $t = new Operator(Operator::ADD);
        $t = new Func(Func::TAN);

        $this->tokens = [];

    }

}
