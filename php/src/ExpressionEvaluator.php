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

        $result = $this->evaluatePostfix($tokens);

        return $result;

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

            switch( $token->name ) {
                case Token::ADD:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = $op1 + $op2;
                    break;

                case Token::SUBTRACT:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = $op1 - $op2;
                    break;

                case Token::MULTIPLY:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = $op1 * $op2;
                    break;

                case Token::DIVIDE:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = $op1 / $op2;
                    break;

                case Token::AND:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = (int) ($op1 && $op2);
                    break;

                case Token::OR:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = (int) ($op1 || $op2);
                    break;

                case Token::NOT:
                    $op1 = array_pop($stack);
                    $stack[] = (int) !$op1;
                    break;

                case Token::EQ:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = (int) ($op1 == $op2);
                    break;

                case Token::LT:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = (int) ($op1 < $op2);
                    break;

                case Token::LTE:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = (int) ($op1 <= $op2);
                    break;

                case Token::GT:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = (int) ($op1 > $op2);
                    break;

                case Token::GTE:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = (int) ($op1 >= $op2);
                    break;

                case Token::MODULO:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = $op1 % $op2;
                    break;

                case Token::POWER:
                    $op1 = array_pop($stack);
                    $op2 = array_pop($stack);
                    $stack[] = $op1 ** $op2;
                    break;

                case Token::SIN:
                    $op1 = array_pop($stack);
                    $stack[] = sin($op1);
                    break;

                case Token::COS:
                    $op1 = array_pop($stack);
                    $stack[] = cos($op1);
                    break;

                case Token::TAN:
                    $op1 = array_pop($stack);
                    $stack[] = tan($op1);
                    break;

                case Token::ARCSIN:
                    $op1 = array_pop($stack);
                    $stack[] = asin($op1);
                    break;

                case Token::ARCCOS:
                    $op1 = array_pop($stack);
                    $stack[] = acos($op1);
                    break;

                case Token::ARCTAN:
                    $op1 = array_pop($stack);
                    $stack[] = atan($op1);
                    break;

                case Token::LOG:
                    $op1 = array_pop($stack);
                    $stack[] = log10($op1);
                    break;

                case Token::LN:
                    $op1 = array_pop($stack);
                    $stack[] = log($op1);
                    break;

                case Token::SQRT:
                    $op1 = array_pop($stack);
                    $stack[] = sqrt($op1);
                    break;

                case Token::ABS:
                    $op1 = array_pop($stack);
                    $stack[] = abs($op1);
                    break;

                case Token::INT:
                    $op1 = array_pop($stack);
                    $stack[] = int($op1);
                    break;

            }

        }

        print_r($stack);

        return (string) reset($stack);

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
