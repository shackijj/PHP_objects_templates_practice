<?php

namespace woo\command;

require_once( "woo/domain/Space.php" );

class AddSpace extends Command {

    function doExecute( \woo\controller\Request $request ) {
        $name = $request->getProperty("space_name");
        $venue_id = $request->getProperty("venue_id");
        if ( is_null( $name ) ) {
            $request->addFeedback( "Space is not defined" );
            return self::statuses('CMD_INSUFFICIENT_DATA');
        } else {
            $space_obj = new \woo\domain\Space( $name, $venue_id );
            $venue = $request->getObject( "venue" );
            $space_obj->setVenue( $venue );

            $mapper = $space_obj->finder();
            $mapper->insert( $space_obj );

            $request->setObject( 'space', $space_obj );
            $request->addFeedback("'$name' added to ({$space_obj->getId()})" );
            return self::statuses('CMD_OK');
        }
    }
}

?>

