<?php

namespace woo\mapper;

require_once( "woo/mapper/VenueSelectionFactory.php" );
require_once( "woo/mapper/IdentityObjects.php" );
require_once( "woo/domain/Venue.php" );

$vsf = new VenueSelectionFactory();
$vio = new VenueIdentityObject();

$vio->field("name")->eq("The Happy Hairband");

print_r( $vsf->newSelection( $vio ) );
?>
