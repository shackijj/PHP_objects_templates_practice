<?php 

require_once( "woo/domain/Venue.php" );

$collection = \woo\domain\Venue::getCollection( "woo\domain\Venue" );

$collection->add( new \woo\domain\Venue( null, "Loud and Thumping" ) );
$collection->add( new \woo\domain\Venue( null, "Eezy" ) );
$collection->add( new \woo\domain\Venue( null, "Duck and Badger" ) );

foreach( $collection as $venue ) {
    print $venue->getName() . "\n";
}
