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

        $tokens = $this->reversePolish($tokens);

        $result = $this->evaluatePostfix($tokens);

        return $result;

    }

    protected function debug( array $stack, array $out ) {
        echo 'Stack: ';
        foreach( $stack as $frame) {
            echo $frame->value, ' ';
        }
        echo "\nOut: ";
        foreach( $out as $frame) {
            echo $frame->value, ' ';
        }
        echo "\n\n";
    }

    protected function reversePolish( array $tokens ): array {

        $stack = [];
        $out = [];

        foreach( $tokens as $token ) {


            // ignore whitespace
            if( $token->isWhitespace() ) {
                continue;
            }
            $this->debug($stack, $out);

            // if token is a closing paren then pop the stack until an open paren is found is found or the stack is empty
            if( $token->name == Token::CLOSE_PAREN ) {

                $current = array_pop($stack);

                while( $current->name != Token::OPEN_PAREN ) {
                    $out[] = $current;
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
                        if( empty($stack) ) {
                            break;
                        }
                        $top = end($stack);
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

        $this->debug($stack, $out);

        return $out;

    }

    protected function evaluatePostfix( array $tokens ): string {

        // loop through the tokens
        // if the current token is an operand then push it onto the stack
        // else pop the desired number of operands from the stack (according to the operator),
        // perform the operation and push the result onto the stack.

        $stack = [];

        foreach( $tokens as $token ) {

            if( $token->isOperand() ) {
                $stack[] = $token->value;
                continue;
            }

            $stack = Operator::{$token->name}($stack);

        }

        return (string) reset($stack);

    }

    protected function doSingleOp( array $stack, $operator ) {


    }

    public function getPrecedence( $token ) {

        $operators = [
            Token::OR          => 20,
            Token::AND         => 30,
            Token::NOT         => 40,
            Token::EQ          => 50,
            Token::LT          => 50,
            Token::LTE         => 50,
            Token::GT          => 50,
            Token::GTE         => 50,
            Token::OPEN_PAREN  => 60,
            Token::CLOSE_PAREN => 70,
            Token::ADD         => 70,
            Token::SUBTRACT    => 70,
            Token::MODULO      => 80,
            Token::MULTIPLY    => 90,
            Token::DIVIDE      => 90,
            Token::POWER       => 100,
            Token::INT         => 110,
            Token::ABS         => 120,
            Token::SQRT        => 130,
            Token::LOG         => 140,
            Token::LN          => 140,
            Token::SIN         => 150,
            Token::COS         => 150,
            Token::TAN         => 150,
            Token::ARCSIN      => 150,
            Token::ARCCOS      => 150,
            Token::ARCTAN      => 150,
        ];

        return $operators[$token->name] ?? 1000;

    }

}
