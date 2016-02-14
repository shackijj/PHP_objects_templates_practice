<?php

namespace woo\mapper;
require_once( "woo/mapper/Collection.php" );

class VenueCollection extends \woo\mapper\Collection {
    public function targetClass() {
        return "\woo\domain\Venue";
    }
}

class SpaceCollection extends \woo\mapper\Collection {
    public function targetClass() {
        return "\woo\domain\Space";
    }
}

class EventCollection extends \woo\mapper\Collection {
    public function targetClass() {
        return "\woo\domain\Event";
    }
}

?>
