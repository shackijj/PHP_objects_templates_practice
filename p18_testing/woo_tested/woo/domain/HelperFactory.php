<?php

namespace woo\domain;

require_once( "woo/mapper/EventMapper.php" );
require_once( "woo/mapper/VenueMapper.php" );
require_once( "woo/mapper/SpaceMapper.php" );
require_once( "woo/mapper/Collections.php");

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
class HelperFactory {
    public function getCollection( $type ) {
        $type = preg_replace( '|^.*\\\|', "", $type );
        $collection_class = "\\woo\\mapper\\{$type}Collection";
        if ( class_exists( $collection_class ) ) {
            return new $collection_class();
        }
    }

    public function getFinder( $type ) {
        $type = preg_replace( '|^.*\\\|', "", $type );
        $mapper_class = "\\woo\\mapper\\{$type}Mapper";
        if ( class_exists( $mapper_class ) ) {
            return new $mapper_class();
        }
    }     
}
                            
?>
