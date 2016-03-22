<?php

namespace woo\command;

require_once( "woo/domain/Venue.php" );

class AddVenue extends Command {
 
    function doExecute( \woo\controller\Request $request ) {

        $name = $request->getProperty("venue_name");
        if ( is_null( $name ) ) {
            $request->addFeedback( "Name is not defined" );
            return self::statuses('CMD_INSUFFICIENT_DATA');
        } else {
            $venue_obj = new \woo\domain\Venue( null, $name );
            $request->setObject( 'venue', $venue_obj );
            $venue_obj->finder()->insert( $venue_obj );
            $request->addFeedback("'$name' added to ({$venue_obj->getId()})" );
            return self::statuses('CMD_OK');
        }
    }
}

?>
