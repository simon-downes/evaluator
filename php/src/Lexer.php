<?php

namespace Evaluator;

use InvalidArgumentException;
use RuntimeException;

class Lexer {

    protected $tokens = [];

    public function __construct() {


    }

    public function addToken( string $type, string $name, string $pattern = '' ): void {

        if( empty($pattern) ) {
            $pattern = sprintf('/^%s/', preg_quote($name));
        }

        $this->tokens[$name] = [
            'type'    => $type,
            'pattern' => $pattern,
        ];

    }

    public function tokenise( string $expr ): array {

        $tokens = [];
        $buffer = $expr;

        while( $buffer ) {

            foreach( $this->tokens as $name => $token ) {
                if( preg_match($token['pattern'], $buffer, $matches) ) {
                    $token = Token::fromString($token['type'], $matches[0]);

                    $tokens[] = $token;

                    $buffer = substr($buffer, strlen((string) $token));

                    continue 2;

                }
            }

            // should never get here as we should have grabbed a valid token, throw an exception
            throw new RuntimeException(sprintf("Unknown character '%s' at position %d ", substr($buffer, 0, 1), strlen($expr) - strlen($buffer) + 1));

        }

        print_r($tokens);

        return $tokens;

    }

}
