<?php

namespace Evaluator;

class Operator {

    public static function add( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = $op1 + $op2;
        return $stack;
    }

    public static function subtract( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = $op1 - $op2;
        return $stack;
    }

    public static function multiply( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = $op1 * $op2;
        return $stack;
    }

    public static function divide( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = $op1 / $op2;
        return $stack;
    }

    public static function and( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = (int) ($op1 && $op2);
        return $stack;
    }

    public static function or( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = (int) ($op1 || $op2);
        return $stack;
    }

    public static function not( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = (int) !$op1;
        return $stack;
    }

    public static function eq( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = (int) ($op1 == $op2);
        return $stack;
    }

    public static function lt( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = (int) ($op1 < $op2);
        return $stack;
    }

    public static function lte( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = (int) ($op1 <= $op2);
        return $stack;
    }

    public static function gt( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = (int) ($op1 > $op2);
        return $stack;
    }

    public static function gte( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = (int) ($op1 >= $op2);
        return $stack;
    }

    public static function modulo( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = $op1 % $op2;
        return $stack;
    }

    public static function power( array $stack ) {
        $op1 = array_pop($stack);
        $op2 = array_pop($stack);
        $stack[] = $op1 ** $op2;
        return $stack;
    }

    public static function sin( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = sin($op1);
        return $stack;
    }

    public static function cos( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = cos($op1);
        return $stack;
    }

    public static function tan( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = tan($op1);
        return $stack;
    }

    public static function arcsin( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = asin($op1);
        return $stack;
    }

    public static function arccos( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = acos($op1);
        return $stack;
    }

    public static function arctan( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = atan($op1);
        return $stack;
    }

    public static function log( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = log10($op1);
        return $stack;
    }

    public static function ln( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = log($op1);
        return $stack;
    }

    public static function sqrt( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = sqrt($op1);
        return $stack;
    }

    public static function abs( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = abs($op1);
        return $stack;
    }

    public static function int( array $stack ) {
        $op1 = array_pop($stack);
        $stack[] = int($op1);
        return $stack;
    }

}
