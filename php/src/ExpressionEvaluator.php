<?php

namespace Evaluator;

use InvalidArgumentException;

class ExpressionEvaluator {

    protected $lexer;

    public function __construct( Lexer $lexer ) {

        $this->lexer = $lexer;

    }

    public function evaluate( string $expression ): string {

        //$expression = '-12.45+45';

        $expression = mb_strtolower($expression);

        $tokens = $this->lexer->tokenise($expression);

        print_r($tokens);

        $tokens = $this->reversePolish($tokens);

        print_r($tokens);

        return $expression;

    }

    protected function reversePolish( array $tokens ): array {

        $stack = [];
        $out = [];

        foreach( $tokens as $token ) {

            // ignore whitespace
            if( $token->isWhitespace() ) {
                continue;
            }
            // if token is a closing paren then pop the stack until an open paren is found is found or the stack is empty
            elseif( $token->name == Token::CLOSE_PAREN ) {

                $current = array_pop($stack);

                while( $current->name != Token::OPEN_PAREN ) {
                    $out[] = $token;
                    if( empty($stack) ) {
                        break;
                    }
                    $current = array_pop($stack);
                }

            }
            // if token is an opening paren then push it onto the stack
            elseif( $token->name == Token::OPEN_PAREN ) {
                $stack[] = $token;
            }

            // if the token is an operator then while the top of stack contains an operator
            // of higher precedence than the current operator, pop the stack to the output buffer
            elseif( $token->isOperator() ) {

                if( $stack ) {

                    $top = end($stack);

                    while( $this->getPrecedence($token) <= $this->getPrecedence($top) ) {
                        $out[] = array_pop($stack);
                        $top = end($stack);
                        if( empty($stack) ) {
                            break;
                        }
                    }

                }

                // now add the operator to the stack
                $stack[] = $token;

            }
            else {
                $out[] = $token;
            }

        }

        // pop the remainder of the stack
        while( $stack ) {
            $out[] = array_pop($stack);
        }

        return $out;

    }

    public function getPrecedence( $token ) {

        if( empty($token) || !$token->isOperator() ) {
            return 1000;
        }

        return 0;

    }

}
