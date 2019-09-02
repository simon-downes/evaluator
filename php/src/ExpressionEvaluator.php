<?php

namespace Evaluator;

use InvalidArgumentException;

class ExpressionEvaluator {

    protected $lexer;

    public function __construct( Lexer $lexer ) {

        $this->lexer = $lexer;

    }

    public function evaluate( string $expression ): string {

        $expression = mb_strtolower($expression);

        $tokens = $this->lexer->tokenise($expression);

        print_r($tokens);

        return $expression;

    }

}
