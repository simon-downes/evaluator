<?php

namespace Evaluator;

use RuntimeException;

class Lexer {

    protected $tokens = [];

    public function addToken( string $type, string $name, string $pattern = '' ): void {

        // creating a Token instance validates that type and name are valid
        $token = new Token($type, $name);

        if( empty($pattern) ) {
            $pattern = sprintf('/^%s/', preg_quote($token->name));
        }

        $this->tokens[$token->name] = [
            'type'    => $token->type,
            'pattern' => $pattern,
        ];

    }

    public function tokenise( string $expr ): array {

        $tokens = [];
        $buffer = $expr;

        while( $buffer ) {

            foreach( $this->tokens as $name => $token ) {
                if( preg_match($token['pattern'], $buffer, $matches) ) {

                    $token = new Token($token['type'], $name, $matches[0]);

                    $tokens[] = $token;

                    $buffer = substr($buffer, strlen($token->value));

                    continue 2;

                }
            }

            // should never get here as we should have grabbed a valid token
            // if we're here it's because the next character in the expression isn't the start of a valid token
            throw new RuntimeException(sprintf("Unknown character '%s' at position %d ", substr($buffer, 0, 1), strlen($expr) - strlen($buffer) + 1));

        }

        return $tokens;

    }

}
