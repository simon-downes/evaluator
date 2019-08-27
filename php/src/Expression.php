<?php

namespace Evaluator;

use InvalidArgumentException;

class Expression {

    protected $expr;

    protected $tokens;

    public function __construct( string $expr ) {

        $this->expr = mb_strtolower($expr);

        $this->tokenise();

    }

    public function evaluate(): string {

        return $this->expr;

    }

    protected function tokenise(): void {

        $token_type = null;
        $token      = '';

        $char_type = null;
        $char      = '';

        $this->tokens = [];

        $expr_len = strlen($this->expr);

        for( $i = 0; $i < $expr_len; $i++ ) {

            $char = $this->expr[$i];

            $char_type = $this->getCharTokenType($char);

            echo "CHR\t$char_type\t$char\n";

            if( empty($token_type) ) {
                $token_type = $char_type;
            }

            // we've changed token types so add the current token to the list and reset the buffer
            if( $char_type != $token_type ) {
                echo "TOKEN\t$token_type\t$token\n";

                // handle operators followed by a negative number
                if( $token_type == Token::OPERATOR && strlen($token) > 1 && substr($token, -1) == '-' ) {
                    $this->tokens[] = Token::fromString($token_type, substr($token, 0, -1));
                    $token = '-'. $char;
                    $token_type = Token::OPERAND;
                    continue;
                }

                $this->tokens[] = Token::fromString($token_type, $token);
                $token_type = $char_type;
                $token = $char;
                continue;
            }

            // haven't changed token type so append to token buffer
            $token .= $char;



        }

        // add the outstanding token to the list
        $this->tokens[] = Token::fromString($token_type, $token);

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
