<?php

namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );
require_once( "woo/domain/Venue.php" );

class Space extends DomainObject{
    private $id;
    private $name;
    private $venue_id;
    private $venue_obj;

    function __construct( $name, $venue_id ) {
        $this->name = $name;
        $this->venue_id = $venue_id;
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }
    
    function setVenue( \woo\domain\Venue $venue ) {
        $this->venue_obj = $venue;        
    }

    function getVenue() {
        return $this->venue_obj;
    } 
}
?>

