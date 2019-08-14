# Evaluator

An expression evaluator engine implemented in a variety of languages (eventually).

Each implementation provides a command-line application that accepts a math expression as a string argument,
passes that to an evaluation engine and outputs the result.

## Features

Support for the following operators and functions is provided by each implementation:

- Operators
  - Arithmetic: `-`, `+`, `*`, `/`
  - Logical: `&` (and),  `|` (or), `!` (not)
  - Equivalence: `=`,  `<`, `<=`, `>`, `>=`
  - Other: `(`, `)`, `%` (modulo), `^` (power)

- Functions
  - `sin()`
  - `cos()`
  - `tan()`
  - `arcsin()`
  - `arccos()`
  - `arctan()`
  - `log()`
  - `ln()`
  - `sqrt()`
  - `abs()`
  - `int()`

## Implementation Algorithm

Each implementation follows a similar algorithm:

- Convert the string into a list of tokens
- Convert the token list from infix to postfix (reverse polish) notation
- Evaluate the postfix token list using a stack
