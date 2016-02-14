<?php

namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );
require_once( "woo/mapper/Collection.php" );


/*
interface VenueCollection extends \Iterator {
    function add( DomainObject $venue );
}

interface SpaceCollection extends \Iterator {
    function add( DomainObject $space );
}

interface EventCollection extends \Iterator {
    function add( DomainObject $event );
}

*/
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

class HelperFactory {
    public function getCollection( $class ) {
        $collection_class = "{$class}Collection";
        if ( class_exists( $collection_class ) ) {
            return new $collection_class();
        }
    }

    public function getFinder( $class ) {
        $mapper_class = "{$class}Mapper";
        if ( class_exists( $mapper_class ) ) {
            return new $mapper_class();
        }
    }     
}
                            
?>
