<?php

abstract class Question {
    protected $prompt;
    protected $marker;

    function __construct( $prompt, Marker $marker ) {
        $this->marker = $marker;
        $this->prompt = $prompt;
    }

    function mark( $response ) {
        return $this->marker->mark( $response );
    }
}

class TextQuestion extends Question {}
class AVQuestion extends Question {}

abstract class Marker {
    protected $test;

    function __construct( $test ) {
        $this->test = $test;
    }

    abstract function mark( $response );
}

class MarkLogicMarker extends Marker {
    private $engine;

    function __construct( $test ) {
        parent::__construct( $test );
        // $this->engine = new MarkParse( $test );
    }

    function mark( $response ) {
        // return $this->engine->evaluate( $response );
        return true;
    }
}

class MatchMarker extends Marker {
    function mark( $response ) {
        return ( $this->test == $response );
    }
}

class RegexpMarker extends Marker {
    function mark( $response ) {
        return ( preg_match( $this->test, $response ) );
    }
}

$markers = array( new RegexpMarker( "/F.ve/" ),
                  new MatchMarker( "Five" ),
                  new MarkLogicMarker( '$input quals "Five"' )
                );

foreach( $markers as $marker ) {
    print get_class( $marker ) . "\n";
    $question = new TextQuestion( "How many edges the Cremlin star has?", $marker);

    foreach( array("Five", "Four") as $response ) {
        print "\tResponse is: $response ";
        if ( $question->mark($response) ) {
            print "Right! \n";
        }
        else {
            print "Not right! \n";
        }
    }
}   
