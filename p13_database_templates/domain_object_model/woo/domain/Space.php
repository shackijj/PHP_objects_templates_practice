<?php

namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );
require_once( "woo/domain/Venue.php" );
require_once( "woo/domain/Event.php" );

class Space extends DomainObject{
    private $name;
    private $venue_id;
    private $venue_obj;
    private $events;

    function __construct( $id, $name ) {
        parent::__construct( $id );
        $this->name = $name;
        $this->events = null;       
    }

    function addEvent( \woo\domain\Event $event ) {
        $this->events->add( $event );
        $event->setSpace( $this );
    }    

    function setEvents( EventCollection $events ) {
        $this->events = $events;
    }

    function getEvents() {
        if ( is_null( $this->events ) ) {
            $finder = self::getFinder( "woo\domain\Event" );
            $this->events = $finder->findBySpaceId( $this->getId() );
        }
        return $this->events;
    }         

    function getName() {
        return $this->name;
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

