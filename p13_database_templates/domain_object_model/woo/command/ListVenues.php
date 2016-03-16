<?php

namespace woo\command;

require_once( "woo/domain/Venue.php" );

class ListVenues extends Command {

    function doExecute( \woo\controller\Request $request ) {
        $finder = \woo\domain\Venue::getFinder();
        $venue_collection = $finder->findAll();
        $request->setObject('venues', $venue_collection ); 
        return self::statuses('CMD_OK');
    }
}

?>

