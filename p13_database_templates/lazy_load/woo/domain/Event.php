<?php

namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );
require_once( "woo/domain/Space.php" );

class Event extends DomainObject {
    private $id;
    private $name;
    private $start;
    private $duration;
    private $space_id;
    private $space_obj;

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

    function setSpace( \woo\domain\Space $space ) {
        $this->space_obj = $space;  
        $this->markDirty();      
    }

    function getSpace() {
        return $this->space_obj;
    } 

    function setStart( $start ) {
        $this->start = $start;
        $this->markDirty();
    }

    function getStart() {
        return $this->start;
    }
    
    function setDuration( $duration ) {
        $this->duration = $duration;
        $this->markDirty();
    }

    function getDuration() {
        return $this->duration;
    }
}

?>
