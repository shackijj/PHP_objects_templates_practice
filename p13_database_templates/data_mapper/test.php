<?php 

require_once( "woo/domain/Venue.php" );

$venue = new \woo\domain\Venue();
$mapper = $venue->finder();
$venue->setName( "The Likely Lounge" );
$mapper->insert( $venue );
$venue = $mapper->find( 1 );
print_r( $venue );

?>
