<?php

namespace woo\mapper;

require_once("woo/domain/Venue.php");
require_once("woo/domain/Space.php");
require_once("woo/domain/Event.php");

abstract class DomainObjectFactory {
    abstract function createObject( array $array );

    protected function getFromMap( $class, $id ) {
        return \woo\domain\ObjectWatcher::exists( $class, $id );
    }

    protected function addToMap( \woo\domain\DomainObject $obj ) {
        return \woo\domain\ObjectWatcher::add( $obj );
    }
}

class VenueDomainObjectFactory extends DomainObjectFactory {
    public function createObject( array $array ) {
        $class = "\woo\domain\Venue";
        $old = $this->getFromMap( $class, $array['id'] );
        if ( $old ) { return $old; }
                
        $obj = new $class( $array['id'] );
        $obj->setName( $array['name'] );
        $this->addToMap( $obj );
        $obj->markClean();
        return $obj;
    }
}

class SpaceDomainObjectFactory extends DomainObjectFactory {
    public function createObject( array $array ) {
        $class = "\woo\domain\Space";
        $old = $this->getFromMap( $class, $array['id'] );
        if ( $old ) { return $old; }
         
        $obj = new $class( $array['id'], $array['name'] );
        $obj->setName( $array['name'] );

        //$venue_mapper = new VenueMapper();
        //$venue = $venue_mapper->find( $array['venue'] );
         
        // $event_mapper = new EventMapper();
        // $events_collection = $event_mapper->findBySpaceId( $array['id'] );
        // $obj->setEvents( $event_collection );

        $factory = PersistentFactory::getFactory( "woo\\domain\\Venue" );
        $finder = new \woo\mapper\DomainObjectAssembler( $factory );
        $idobj = $factory->getIdentityObject()->field('id')->eq( $array['venue'] ); 
        $venue = $finder->findOne( $idObj );
        $obj->setVenue( $obj );
        

        $factory = PersistentFactory::getFactory( "woo\\domain\\Event" );
        $finder = new \woo\mapper\DomainObjectAssembler( $factory );
        $idobj = $factory->getIdentityObject()->field('space')->eq($array['id']);
        $event_collection = $find->find( $idobj );
        $obj->setEvents( $event_collection );
        $obj->markClean();

        // $this->addToMap( $obj );
        // Why don't we save it?
        
        return $obj;
    }
}

class EventDomainObjectFactory extends DomainObjectFactory {
    public function createObject( array $array ) {
        $class = "\woo\domain\Event";
        $old = $this->getFromMap( $class, $array['id'] );
        if ( $old ) { return $old; }

        $obj = new $class( $array['id'], $array['name'] );
        $obj->setName( $array['name'] );

        // $space_mapper = new SpaceMapper();
        // $space = $space_mapper->find( $array['space'] );

        $factory = PersistentFactory::getFactory( "woo\\domain\\Space" );
        $finder = new \woo\mapper\DomainObjectAssembler( $factory );
        $idobj = $factory->getIdentityObject()->field('id')->eq( $array['space']); 
        $space = $finder->findOne( $idObj );

        $obj->setSpace( $space );
        
        $obj->setStart( $array['start'] );
        $obj->setDuration( $array['duration'] );
        $obj->markClean();       
        // $this->addToMap( $obj );
        return $obj;
    }
}

?>
