<?php

namespace woo\mapper;
require_once( "woo/mapper/Collection.php" );
require_once( "woo/domain/Collections.php" );
require_once( "woo/domain/Venue.php" );

class VenueCollection extends \woo\mapper\Collection
    implements \woo\domain\VenueCollection {
    public function targetClass() {
        return "\woo\domain\Venue";
    }
}

class SpaceCollection extends \woo\mapper\Collection 
    implements \woo\domain\SpaceCollection {
    public function targetClass() {
        return "\woo\domain\Space";
    }
}

class EventCollection extends \woo\mapper\Collection 
    implements \woo\domain\EventCollection {
    public function targetClass() {
        return "\woo\domain\Event";
    }
}

?>
