<?php

namespace woo\command;

//require_once( "woo/domain/Venue.php" );
require_once( "woo/mapper/PersistenceFactory.php" );
require_once( "woo/mapper/DomainObjectAssembler.php" );

class ListVenues extends Command {

    function doExecute( \woo\controller\Request $request ) {
        //$finder = \woo\domain\Venue::getFinder();
        //$venue_collection = $finder->findAll();

        $factory = \woo\mapper\PersistenceFactory::getFactory( 'woo\\domain\\Venue' );
        $finder = new \woo\mapper\DomainObjectAssembler( $factory );
        $idobj = $factory->getIdentityObject();
        $venue_collection = $finder->find( $idobj );
        
        $request->setObject('venues', $venue_collection ); 
        return self::statuses('CMD_OK');
    }
}

?>

