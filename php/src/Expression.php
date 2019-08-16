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

        $token_type     = '';
        $token          = '';

        $char_type = null;
        $char      = '';

        $tokens = [];

        for( $i = 0; $i < strlen($this->expr); $i++ ) {

            $char = $this->expr[$i];

            $char_type = $this->getCharTokenType($char);

            echo "CHR\t$char_type\t$char\n";

            if( $i == 0 ) {
                $token_type = $char_type;
            }

            // haven't changed token type so append to token buffer
            if( $char_type != $token_type ) {
                echo "TOKEN\t$token_type\t$token\n";
                // we've changed token types so add the current token to the list and reset the buffer
                //print_r("{$token_type}\t{$token}\n");
                $tokens[] = Token::fromString($token_type, $token);
                $token_type = $char_type;
                $token = $char;
                continue;
                }

            $token .= $char;



        }

        print_r($tokens);

        // convert string to tokens
        $t = new Operand('-123.45');
        $t = new Operator(Operator::ADD);
        $t = new Func(Func::TAN);

        $this->tokens = [];

    }

    protected function getCharTokenType( string $char ): string {

        if( Operator::isValidChar($char) ) {
            return Token::OPERATOR;
        }
        elseif( Operand::isValidChar($char) ) {
            return Token::OPERAND;
        }
        elseif( Func::isValidChar($char) ) {
            return Token::FUNC;
        }
        elseif( Whitespace::isValidChar($char) ) {
            return Token::WHITESPACE;
        }

        throw new InvalidArgumentException("Unknown character: '{$char}'");

    }

}
