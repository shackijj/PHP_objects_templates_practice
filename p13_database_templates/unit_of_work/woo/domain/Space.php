<?php

namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );
require_once( "woo/domain/Venue.php" );

class Space extends DomainObject{
    private $id;
    private $name;
    private $venue_id;
    private $venue_obj;

    function __construct( $id, $name ) {
        $this->name = $name;
        parent::__construct( $id );       
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }
    
    function setName( $name ) {
        $this->name = $name;
        $this->markDirty();
    }

    function setVenue( \woo\domain\Venue $venue ) {
        $this->venue_obj = $venue;  
        $this->markDirty();      
    }

    function getVenue() {
        return $this->venue_obj;
    } 
}
?>

