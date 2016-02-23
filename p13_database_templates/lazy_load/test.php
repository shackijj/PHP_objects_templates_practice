<?php 

require_once( "woo/domain/Venue.php" );
require_once( "woo/domain/Space.php" );
require_once( "woo/controller/ApplicationHelper.php");


$helper = \woo\controller\ApplicationHelper::instance();
$helper->init();

$finder = \woo\domain\Space::getFinder();

$space = $finder->find( 1 );

$space->addEvent(
    new \woo\domain\Event( null, "First Event" );
);

$space->addEvent( 
    new \woo\domain\Event( null, "Second Event" )
);

\woo\domain\ObjectWatcher::instance()->performOperations();

?>
