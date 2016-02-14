<?php 

require_once( "woo/domain/Venue.php" );

$finder = \woo\domain\Venue::getFinder( "woo\domain\Venue" );

$collection = $find::

foreach( $collection as $venue ) {
    print $venue->getName() . "\n";
}
