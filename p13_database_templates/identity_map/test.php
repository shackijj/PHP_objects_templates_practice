<?php 

require_once( "woo/domain/Venue.php" );
require_once( "woo/controller/ApplicationHelper.php");


$helper = \woo\controller\ApplicationHelper::instance();
$helper->init();

$venue = new \woo\domain\Venue();
$mapper = $venue->finder();
$venue->setName( "The Likely Lounge" );
$mapper->insert( $venue );
$venue = $mapper->find( 21 );
$venue = $mapper->find( 21 );


$space = new \woo\domain\Space( null, null );
$finder = $space->finder();
$space_collection = $finder->findByVenue( 21 );
foreach( $space_collection as $space) {
    print_r( $space );
}

?>
