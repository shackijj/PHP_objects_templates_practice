<?php

namespace gi\parse;

class Scanner {

    const WORD         = 1;
    const QUOTE        = 2;
    const APOS         = 3;
    const WHITESPACE   = 6;
    const EOL          = 8;
    const CHAR         = 9;
    const EOF          = 0;
    const SOF          = -1;

    protected $line_no = 1;
    protected $char_no = 0;
    protected $token   = null;
    protected $token_type = -1;

    function __construct(Reader $r, Context $context) {
        $this->r = $r;
        $this->context = $context;
    }

    function getContext() {
        return $this->context;
    }

    function eatWhiteSpace() {
        $ret = 0;
        if ( $this->token_type != self::WHITESPACE &&
             $this->token_type != self::EOL ) {
             return $ret;
        }
        while ( $this->nextToken() == self::WHITESPACE ||
                $this->token_type  == self::EOL ) {
            $ret++;
        }
    }

    function getTypeString( $int=-1 ) {
        if ( $int < 0 ) { $int = $this->tokenType(); }
        if ( $int < 0 ) { return null; }
        $resolve = array(
            self::WORD       => 'WORD'      ,
            self::QUOTE      => 'QUOTE'     ,
            self::APOS       => 'APOS'      ,
            self::WHITESPACE => 'WHITESPACE',
            self::EOL        => 'EOL'       ,
            self::CHAR       => 'CHAR'      ,
            self::EOF        => 'EOF'
        );
        return $resolve[$int];
    }

    function tokenType() {
        return $this->token_type;
    }

    function token() {
        return $this->token;
    }

    function isWord() {
        return ( $this->token_type == self::WORD );
    }

    function isQuote() {
        return ( $this->token_type == self::APOS ||
                 $this->token_type == self::QUOTE );
    }

    function line_no() {
        return $this->line_no;
    }

    function char_no() {
        return $this->char_no;
    }

    function __clone() {
        $this->r = clone($this->r);
    }

    function nextToken() {
        $this->token = null;
        $type;
        while( ! is_bool($char = $this->getChar()) ) {
            if ( $this->isEolChar($char) ) {
                $this->token = $this->manageEolChars( $char );
                $this->line_no++;
                $this->char_no = 0;
                $type = self::EOL;
                return ( $this->token_type = self::EOL );
            } else if ( $this->isWordChar( $char ) ) {
                $this->token = $this->eatWordChars( $char );
                $type = self::WORD;
            } else if ( $this->isSpaceChar( $char ) ) {
                $this->token = $char;
                $type = self::WHITESPACE;
            } else if ( $char == "'" ) {
                $this->token = $char;
                $type = self::APOS;
            } else if ( $char == '"' ) {
                $this->token = $char;
                $type = self::QUOTE;
            } else {
                $type = self::CHAR;
                $this->token = $char;
            }
            $this->char_no += strlen( $this->token() );
            return ( $this->token_type = $type );
        }
        return ( $this->token_type = self::EOF );
    }

    function peekToken() {
        $state = $this->getState();
        $type  = $this->nextToken(); 
        $token = $this->token();
        $this->setState( $state );
        return array( $type, $token );
    }

    function getState() {
        $state = new ScannerState();
        $state->line_no    = $this->line_no;
        $state->char_no    = $this->char_no;
        $state->token      = $this->token;
        $state->token_type = $this->token_type;
        $state->r          = clone($this->r);
        $state->context    = clone($this->context);
        return $state;
    }

    private function getChar() {
        return $this->r->getChar();
    }

    private function eatWordChars( $char ) {
        $val = $char;
        while( $this->isWordChar( $char=$this->getChar() ) ) {
            $val .= $char;
        }
        if ( $char ) {
            $this->pushBackChar();
        }
        return $val;
    }

    function pushBackChar() {
        $this->r->pushBackChar();
        return;
    }

    function isWordChar( $char ) {
        return preg_match( "/[A-Za-z0-9_\-]/", $char );
    }

    private function isSpaceChar( $char ) {
        return preg_match( "/\t| /", $char );
    }

    private function isEolChar( $char ) {
        return preg_match( "/\n|\r/", $char );
    }

    private function manageEolChars( $char ) {
        if ( $char == "\r" ) {
            $next_char = $this->getChar();
            if ( $next_char == "\n" ) {
                return "{$char}{$next_char}";
            } else {
                $this->pushBackChar();
            }
        }
        return $char;
    }

    function getPos() {
        return $this->r->getPos();
    }
}

class ScannerState {
    public $line_no;
    public $char_no;
    public $token;
    public $token_type;
    public $r;
}

class Context {
    public $resultstack = array();

    function pushResult( $mixed ) {
        array_push( $this->resultstack, $mixed );
    }

    function popResult() {
        return array_pop( $this->resultstack );
    }

    function resultCount() {
        return count( $this->resulstack );
    }

    function peekResult() {
        if ( empty( $this->resultstack ) ) {
            throw new Exception( "empty resultstack" );
        }
        return $this->resultstack[count($this->resultstack - 1)];
    }
}

interface Reader {
    function getChar();
    function getPos();
    function pushBackChar();
}

class StringReader implements Reader {
    private $in;
    private $pos;

    function __construct( $in ) {
        $this->in = $in;
        $this->pos = 0;
    }

    function getChar() {
        if ( $this->pos >= strlen( $this->in ) ) {
            return false;
        }
        $char = substr( $this->in, $this->pos, 1 );
        $this->pos++;
        return $char;
    }

    function getPos() {
        return $this->pos;
    }

    function pushBackChar() {
        $this->pos--;
    }

    function string() {
        return $this->in;
    }
}

$context = new \gi\parse\Context();
$user_in = "\$input equals '4' or \$input equals 'four'";
$reader = new \gi\parse\StringReader( $user_in );
$scanner = new \gi\parse\Scanner( $reader, $context );

while ( $scanner->nextToken() != \gi\parse\Scanner::EOF ) {
    print $scanner->token();
    print "\t{$scanner->char_no()}";
    print "\t{$scanner->getTypeString()}\n";
}
?>
