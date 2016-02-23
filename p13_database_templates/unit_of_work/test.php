<?php 

require_once( "woo/domain/Venue.php" );
require_once( "woo/domain/Space.php" );
require_once( "woo/controller/ApplicationHelper.php");


$helper = \woo\controller\ApplicationHelper::instance();
$helper->init();

$venue = new \woo\domain\Venue(null, "The Green Trees");
$venue->addSpace( new \woo\domain\Space( null, "The Space 1") );
$venue->addSpace( new \woo\domain\Space( null, "The Space 2") );
$venue->addSpace( new \woo\domain\Space( null, "The Space 3") );


\woo\domain\ObjectWatcher::instance()->performOperations();

?>
