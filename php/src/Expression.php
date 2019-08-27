<?php

namespace Evaluator;

use InvalidArgumentException;

class Expression {

    protected $expr;

    protected $tokens;

    public function __construct( string $expr ) {

        $this->expr = mb_strtolower($expr);

        print_r(Operator::getPatterns());

        $this->tokenise();

    }

    public function evaluate(): string {

        return $this->expr;

    }

    protected function tokenise(): void {

        $this->tokens = [];

        $expr = $this->expr;

        $token_patterns = [
            Token::OPERAND  => Operand::getPatterns(),
            Token::OPERATOR => Operator::getPatterns(),
        ];

        print_r($token_patterns);

        $i = 0;

        while( $expr ) {
            $i++;
            if( $i > 10 ) {
                break;
            }
            echo "Expr: ", $expr, "\n";
            foreach( $token_patterns as $token_type => $patterns ) {
                foreach( $patterns as $token => $pattern ) {

                    if( preg_match($pattern, $expr, $matches) ) {

                        $token = Token::fromString($token_type, $matches[0]);

                        print_r($token);

                        $this->tokens[] = $token;

                        $expr = substr($expr, strlen((string) $token));

                        echo "New Expr: ", $expr, "\n";

                        continue 2;

                    }
                }
            }

            // TODO: should never get here as we should have grabbed a valid token, throw an exception
            // need to track the number of characters we've removed from expr so we can give an offset

        }

        print_r($this->tokens);

    }

    protected function getCharTokenType( string $char ): string {

        $token_types = [
            Operator::class,
            Operand::class,
            Func::class,
            Whitespace::class,
        ];

        foreach( $token_types as $class ) {
            if( $class::isValidChar($char) ) {
                return $class::TYPE;
            }
        }

        throw new InvalidArgumentException("Unknown character: '{$char}'");

    }

}
