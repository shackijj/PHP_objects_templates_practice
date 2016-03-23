<?php
require_once( "XML_Feed_Parser.php" );

/*
     print "Message: " . $e->getMessage() . "\n";
            print "Code: " . $e->getCode() . "\n";
            print "Class with exception " . $e->getErrorClass() . "\n";
            print "Method with exception " . $e->getErrorMethod() . "\n";
            print "Stacktrace: " . $e->getTraceasString() . "\n";
            print "Data with exception: ";
            print_r( $e->getErrorData() );

*/

class MyPearException extends PEAR_Exception {}

class MyFeedThing {
    function acquire( $source ) {
        try {
            $myfeed = @new XML_Feed_Parser( $source );
            return $myfeed;
        } catch ( XML_Feed_Parser_Exception $e ) {
            throw new MyPearException( "Connection refused", $e );
        }
    }
}


class MyFeedClient {
    function __construct() {
        PEAR_Exception::addObserver( array( $this, "notifyError" ) );
    }

    function process() {
        try {
            $feedt = new MyFeedThing();
            $parser = $feedt->acquire('wrong.xml');
        } catch ( Exception $e ) {
            print "Error. See log file \n";
        }
    }

    function notifyError( PEAR_Exception $e ) {
        // Write another thing
    }
}
