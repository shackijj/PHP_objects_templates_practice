<?php
namespace woo\controller;
require_once("woo/controller/PageController.php");

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

$controller = new AddVenueController();
$controller->process();

?>
