#include <stddef.h>
#include <stdbool.h>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>

#define TOKEN_OPERATOR 1
#define TOKEN_NUMBER 2
#define TOKEN_FUNCTION 3

#define OPENING_PAREN '('
#define CLOSING_PAREN ')'

#define OPERATOR_OPENING_PAREN '('
#define OPERATOR_CLOSING_PAREN ')'
#define OPERATOR_DIVIDE '/'
#define OPERATOR_MULTIPLY '*'
#define OPERATOR_MINUS '-'
#define OPERATOR_ADD '+'
#define OPERATOR_NOT '!'
#define OPERATOR_AND '&'
#define OPERATOR_OR '|'
#define OPERATOR_POWER '^'
#define OPERATOR_LESS_THAN '<'
#define OPERATOR_GREATER_THAN '>'
#define OPERATOR_EQUALS '='

#define PARSE_ERROR 1

typedef struct {
   bool isOperator;
   char data[20];
} TOKEN;

TOKEN* tokenise( char* );
char* tokenise2( char* );
bool isValid( char* );
void replaceWithToken( char*, char*, char) ;
bool isSpace( char );
bool isOperator( char );
bool isNumber( char );
void addToken( TOKEN*, bool, char* );
void appendChar( char*, char );
size_t chopN(char*, size_t);
TOKEN grabToken( char* expr );


int main( int argc, char **argv ) {

    char *src, *expr;
    TOKEN* tokens;

    // get the second argument, the first being the program name
    src = *++argv;

    printf("Source: %s\tLen: %u\n", src, (int) strlen(src));

    // tokenise the expression we should be evaluating
    tokens = tokenise(src);

    printf("Tokens: %i\n", (int) sizeof(tokens));

    // check the tokenised string only contains valid tokens
    if( !isValid(expr) ) {
        printf("Invalid expression: %s\n", src);
        return PARSE_ERROR;
    }

    return EXIT_SUCCESS;

}

size_t chopN(char *str, size_t n) {

    size_t len = strlen(str);

    if (n > len) {
        n = len;
    }

    memmove(str, str + n, len - n + 1);

    return(len - n);

}

// get the next token in an expression
TOKEN grabToken( char* expr ) {

    int i = 0;
    TOKEN token;
    char chr, next;

    // skip whitespace
    while( isSpace(expr[i]) ) {
        i++;
    }

    chr  = expr[i];
    next = expr[i+1];

    token.isOperator = false;

    if( isOperator(chr) ) {

        token.isOperator = true;

        if( chr == OPERATOR_LESS_THAN || chr == OPERATOR_GREATER_THAN ) {
            if( next == OPERATOR_EQUALS ) {
                // <= or >=
                i++;
            }
        }

    }
    else if( isNumber(chr) ) {

        // read until not a number char
        while( isNumber(expr[i]) ) {
            i++;
        }

    }
    else {

        // read until not a function char
        while( !isOperator(expr[i]) && !isNumber(expr[i]) ) {
            i++;
        }

    }

    // always grab at least one character
    if( i == 0 ) {
        i = 1;
    }

    memset(token.data, 0, sizeof(token.data));
    strncpy(token.data, expr, i);

    printf("Found Token: isOperator: %i\tLen: %u\t%s\n", token.isOperator, (int) strlen(token.data), token.data);

    chopN(expr, (size_t) i);

    return token;

}

TOKEN* tokenise( char* expr ) {

    int i = 0;
    TOKEN* tokens;
    char* expr_cpy;

    tokens = malloc(strlen(expr) * sizeof *tokens);

    expr_cpy = strdup(expr);

    // while we still have an expression, extract the next token from the start of the expression
    // and add it to our token array
    while( strlen(expr_cpy) ) {
        tokens[i++] = grabToken(expr_cpy);
    }

    return tokens;

    // initialise local buffers
    // memset(num, 0, sizeof(num));
    // memset(func, 0, sizeof(func));
/*
    for( i = 0; i < strlen(expr); i++ ) {

        // get next character in string
        chr = expr[i];

        printf("Chr %c\n", chr);

        // ignore spaces
        if( isSpace(chr) ) {
            continue;
        }

        else if( isOperator(chr) ) {

            if( strlen(func) ) {
                addToken(tokens, false, func);
                memset(func, 0, sizeof(func));
            }
            else if( strlen(num) ) {
                addToken(tokens, false, num);
                memset(num, 0, sizeof(num));
            }

            buf[0] = chr;
            addToken(tokens, true, buf);
        }

        else if( isNumber(chr) ) {
            appendChar(num, chr);
        }

        else {
            appendChar(func, chr);
        }

        //tokens[i].isOperator = false;


    }

    for( i = 0; i < strlen(expr); i++ ) {
        printf("Token %i:\tisOp: %i\tData: %s\n", i, tokens[i].isOperator, tokens[i].data);
    }*/

/*
    ts[1].isOperator = true;
    strcpy(ts[1].data , "[");

    ts[2].isOperator = true;
    strcpy(ts[2].data , "-");

    printf("t.isOperator: %i\n", ts[2].isOperator);
    printf("t.data: %s\n", ts[2].data);
*/

/*
for (x = 0; x < numStudents; x++){
        students[x].firstName=(char*)malloc(sizeof(char*));
        scanf("%s",students[x].firstName);
        students[x].lastName=(char*)malloc(sizeof(char*));
        scanf("%s",students[x].lastName);
        scanf("%d",&students[x].day);
        scanf("%d",&students[x].month);
        scanf("%d",&students[x].year);
    }
*/

/*
    // Declare test_array_ptr as pointer to array of test_t
    TOKEN (*tokens)[];

    //TOKEN* tokens;

    tokens = malloc(strlen(expr) * sizeof(TOKEN));

    int i = 0, j = 0;
    char num[50];    // current numeric string
    char func[10];   // current function/operator
    char chr;        // current character in expression

    // initialise local buffers
    memset(num, 0, sizeof(num));
    memset(func, 0, sizeof(func));

    for( i = 0; i < strlen(expr); i++ ) {

        // get next character in string
        chr = expr[i];

        // ignore spaces
        if( isSpace(chr) ) {
            continue;
        }

        if( isOperator(chr) ) {

            // we've reached the end of a number so add it to the array
            if( strlen(num) > 0 ) {
                tokens[j]->isOperator = false;
                tokens[j++]->data = num;
                memset(num, 0, sizeof(num));
            }
            else if( strlen(func) > 0 ) {
                tokens[j]->isOperator = true;
                tokens[j++]->data = func;
                memset(func, 0, sizeof(func));
            }

            tokens[j]->isOperator = true;
            tokens[j++]->data = chr;

        }

        else if( isNumber(chr) ) {

        }

        else {

        }

    }

    printf("Tokens: %s\n", src);

    return tokens;
*/
}

void appendChar(char* str, char chr) {
        int len = strlen(str);
        str[len] = chr;
        str[len + 1] = '\0';
}

bool isSpace( char chr ) {

    if( chr == ' ' ) {
        return true;
    }

    return false;

}

bool isOperator( char chr ) {

    switch( chr ) {
        case OPERATOR_OPENING_PAREN:
        case OPERATOR_CLOSING_PAREN:
        case OPERATOR_DIVIDE:
        case OPERATOR_MULTIPLY:
        case OPERATOR_MINUS:
        case OPERATOR_ADD:
        case OPERATOR_NOT:
        case OPERATOR_AND:
        case OPERATOR_OR:
        case OPERATOR_POWER:
            return true;
    }

    return false;

}

bool isNumber( char chr ) {

    switch( chr ) {
        case '0':
        case '1':
        case '2':
        case '3':
        case '4':
        case '5':
        case '6':
        case '7':
        case '8':
        case '9':
        case '.':
            return true;
    }

    return false;

}

void addToken( TOKEN* tokens, bool isOperator, char* data ) {

    static int index;

    printf("T %s\t%i\n", data, (int) strlen(data));

    tokens[index].isOperator = isOperator;

    memset(tokens[index].data, 0, sizeof(tokens[index].data));

    strcpy(tokens[index].data, data);

    index++;
}

/**
    Replace function names and multi-char operators with single character tokens.
    e.g. ">=" becomes "g"; "sin" becomes "s".
 */
char* tokenise2( char* src ) {

    char* expr;

    // create a copy of the source expression that we can manipulate at will
    expr = malloc(sizeof(src));
    strcpy(expr, src);

    // comparison operators
    replaceWithToken(expr, ">=", 'g');
    replaceWithToken(expr, "<=", 'h');

    // logical operators
    replaceWithToken(expr, "not", '!');
    replaceWithToken(expr, "and", '&');
    replaceWithToken(expr, "or", '|');
    replaceWithToken(expr, "xor", '^');

    // "standard" functions
    replaceWithToken(expr, "arcsin", 'S');
    replaceWithToken(expr, "arccos", 'C');
    replaceWithToken(expr, "arctan", 'T');
    replaceWithToken(expr, "sin", 's');
    replaceWithToken(expr, "cos", 'c');
    replaceWithToken(expr, "tan", 't');
    replaceWithToken(expr, "ln", 'n');
    replaceWithToken(expr, "log", 'l');
    replaceWithToken(expr, "sqrt", 'r');
    replaceWithToken(expr, "abs", 'a');
    //replaceWithToken(expr, "int", 'i');
    replaceWithToken(expr, "mod", 'm');
    replaceWithToken(expr, "exp", 'x');

    return expr;

}

bool isValid( char* expr ) {

    // checks the expression doesn't contain any invalid characters and
    // has a matched number of opening and closing parenthesis
    int chr, open = 0, close = 0;

    // only these characters are permitted in expressions; alpha chars being tokens for operators or functions
    char* allowed = "01234567890()+-*/!&|^ghsctSCTlnramx";

    // Loop through each character in the expression
    for( chr = 0; chr < strlen(expr); chr++) {

        // Check if this character appears in the invalid characters string
        if( strchr(allowed, expr[chr]) == NULL) {
            printf("Bad token: %c as position %d\n", expr[chr], chr);
            return false;
        }

        if( expr[chr] == OPENING_PAREN ) {
            open++;
        }

        if( expr[chr] == CLOSING_PAREN ) {
            close++;
        }

    }

    // must have an equal number of opening and closing brackets
    if( open != close ) {
        return false;
    }

    return true;

}

/**
    Replaces a function name with it's single character code.
 */
void replaceWithToken( char* expr, char* func, char token ) {

    int funclen, exprlen;
    char* start;

    // store this so we don't have to calculate it each time
    funclen = strlen(func);

    // get pointer to the first occurrence of the function
    start = strstr(expr, func);

    // replace the function's name with its single character code until we get a null pointer
    // i.e. no more occurrences
    while( start != NULL ) {

        // calculate the length of the expression after the function name (including the null terminator)
        exprlen = (expr + strlen(expr) + 1) - (start + funclen);

        // shift the contents of the expression to the left to overwrite all but the first character of the function name
        memcpy(start + 1, start + funclen, exprlen);

        // set the first character of the function name to its single character code
        memset(start, token, 1);

        // get pointer to the next occurrence of the function
        start = strstr(expr, func);

    }

}

/**
    Convert an expression string into an array of instructions.
 */
/*

void createInstructionArray( char* expr, INSTRUCTION *instructions ) {

    int i = 0, j = 1;
    char num[50];    // current numeric string
    char func[10];   // current function/operator
    char chr;        // current character in expression

    // initialise local buffers
    memset(num, NULL, sizeof(num));
    memset(func, NULL, sizeof(func));

    for( i = 0; i < strlen(expr); i++ ) {

        // get next character in string
        chr = expr[i];

        // ignore spaces
        if( isspace(chr) ) {
            continue;
        }

        if( chr == '-' ) {

            // if number buffer is not empty then we've reached the end of a number
            // so add a new operand element to the expression array
            if( strlen(num) > 0 ) {
                instructions[j].isOperator = false;
                instructions[j++].operand = atof(num);
                memset(num, NULL, sizeof(num));
            }

            // if function buffer is not empty then we've reached the end of a function
            // so add a new operator element to the expression array
            if( strlen(func) > 0 ) {
                instructions[j].isOperator = true;
                instructions[j++].operand = (double) GetOpCode(func);
                memset(func, NULL, sizeof(func));
            }

            // if at start of expression then we should subtract from zero so
            // add a new operand and operator element to the expression array
            if( i == 0 ) {
                instructions[j].isOperator = true;
                instructions[j++].operand = (double) '-';
                instructions[j].isOperator = false;
                instructions[j++].operand = 0;
            }

            // if preceding element was an operator then we must be starting a negative number
            else if( instructions[j - 1].isOperator == true ) {
                if( (char) instructions[j - 1].operand == '-' ) {
                    instructions[j - 1].operand = (double) '+';
                }
                else {
                    num[strlen(num)] = '-';
                }
            }

            // else character is for a subtraction operation
            // so add a new operator operator element to the expression array
            else {
                instructions[j].operator = true;
                instructions[j++].operand = (double) chr;
            }
        }

         // if character is a digit or a decimal point then it must be a numeric character so append it to the numeric string
         else if( isdigit(chr) || (chr == '.') ) {
            num[strlen(num)] = chr;
         }

         else {
            // if numeric buffer is not empty then we've reached the end of a number
            // so add a new operand element to the expression array
            if( strlen(num) > 0 ) {
               instructions[i].operator = false;
               instructions[i++].operand = atof(num);
               memset(num, NULL, sizeof(num));
            }

            // dd a new operator element to the array
            instructions[i].operator = true;
            instructions[i++].operand = (double) sChar;
         }



      if( !isspace(chr) )

         // else if character is a letter then it must be part of a function name
         else if (isalpha(chr)) {
            func[strlen(func)] = chr;
         }

         // else if character is not a digit or a decimal point then it must be an operator
         else if ( isdigit(chr) || (chr == '.') ) {
             // Append the character to the buffer
            num[strlen(num)] = chr;
         }

         // else if character is not a letter, digit or a decimal point then it must be an operator
         else {
            // If number buffer is not empty then we've reached the end of a number
            // so add a new operand element to the expression array
            if ( strlen(num) > 0 ) {
               instructions[j].operator = false;
               instructions[j++].operand = atof(num);
               memset(num, NULL, sizeof(num));
            }

            // If function buffer is not empty then we've reached the end of a function
            // so add a new operator element to the expression array
            if ( strlen(func) > 0 ) {
               instructions[j].operator = true;
               instructions[j++].operand = (double) GetOpCode(func);
               memset(func, NULL, sizeof(func));
            }

            // Add a new operator element to the array
            instructions[j].operator = true;
            instructions[j++].operand = (double)chr;
         }
      }
   }

    // If the buffer is not empty then add a new operand element to the expression array
    if( strlen(num) > 0 ) {
        instructions[j].operator = false;
        instructions[j++].operand = atof(num);
        memset(num, NULL, sizeof(num));
    }

    // Store the number of elements in the data member of the first array element
    instructions[0].operator = false;
    instructions[0].operand = (double) j-1;

    // Reallocate memory for the actual number of elements in the expression
    instructions=(ELEMENT *)realloc(instructions,sizeof(ELEMENT)*j);

    return;

}

char GetOpCode(char* szFunction) {
   // Return the single character operator code for the specified function
   // Examine the first character, if more than one function begins with the
   // same character then examine the second character, etc...

   char cCode;

   // Test the first character of the function name
   switch (szFunction[0]) {
      case 'a':
         switch (szFunction[1]) {
            case 'b':
               cCode = 'a';   // abs
               break;

            case 'n':
               cCode = '&';   // and
               break;

            case 'r':
               switch (szFunction[3]) {
                  case 's':
                     cCode = 'S';   // arcsin
                     break;

                  case 'c':
                     cCode = 'C';   // arccos
                     break;

                  case 't':
                     cCode = 'T';   // arctan
                     break;
               }
               break;
         }
         break;

      case 'c':   // cos
         cCode = 'c';
         break;

      case 'e':   // exp
         cCode = 'x';
         break;

      case 'i':   // int
         cCode = 'i';
         break;

      case 'l':
         switch (szFunction[1]) {
         case 'o':
            cCode = 'l';   // log
            break;

         case 'n':
            cCode = 'n';   // ln
            break;
         }
         break;

      case 'm':
         cCode = 'm';   // mod
         break;

      case 'n':
         cCode = '$';   // not
         break;

      case 'o':
         cCode = 'o';   // or
         break;

      case 's':
         switch (szFunction[1]) {
         case 'i':
            cCode = 's';   // sin
            break;

         case 'q':
            cCode = 'r';   // sqrt
            break;
         }
         break;

      case 't':
         cCode = 't';   // tan
         break;

      case 'x':
         cCode = '#';   // xor
         break;
   }

   return cCode;

}
*/
