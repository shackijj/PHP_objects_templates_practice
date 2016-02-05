<?php

namespace woo\controller;
require_once( "woo/base/Registry.php" );

abstract class PageController {

    abstract function process();

    function forward( $resource ) {
        include( $resource );
        exit(0);
    }

    function getRequest() {
        return \woo\base\ApplicationRegistry::getRequest();
    }
}

class AddVenueController extends PageController {
    function process() {
        try {
            $request = $this->getRequest();
            $name = $request->getProperty( 'venue_name' );
            if ( is_null( $request->getProperty('submitted') ) ) {
                $request->addFeedback("Choose venue name.");
                $this->forward( 'add_venue.php' );
            } else if ( is_null( $name ) ) {
                $request->addFeedback("Name must be chosen");
                $this->forward( 'add_venue.php' );
            }
            $venue = new \woo\domain\Venue( null, $name );
            $this->forward( "ListVenues.php" );
        } catch ( Exception $e ) {
            $this->forward( 'error.php' );
        }
    }
}            
