<?php
require_once( "XML/Feed/Parser.php" );
require_once( "PEAR/Exception.php" );
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
        print get_class( $e ) . ":";
        print $e->getMessage() . "\n";
        $cause = $e->getCause();
        if ( is_object( $cause ) ) {
            print "[REASON] " . get_class( $cause ) . ":";
            print $cause->getMessage() . "\n";
        } else if ( is_array( $cause ) ) {
            foreach( $cause as $sub_e ) {
                print "[REASON] " . get_class( $sub_e ) . ":";
                print $sub_e->getMessage() . "\n";
            }
        }
        print "-----------------\n";
    }
}

$client = new MyFeedClient();
$client->process();
