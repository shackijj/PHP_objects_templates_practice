<?php

namespace woo\mapper;

require_once( "woo/mapper/Collections.php" );
require_once( "woo/mapper/DomainObjectFactory.php" );

abstract class PersistenceFactory {
    public static function getFactory( $typestr ) {
        switch( $typestr ) {
            case "woo\\domain\\Venue":
                return new VenuePersistenceFactory();
                break;
            case "woo\\domain\\Space":
                return new SpacePersistenceFactory();
                break;
            case "woo\\domain\\Event":
                return new EventPersistenceFactory();
                break;
        }
    }

    abstract function getCollection( array $raw );
    abstract function getDomainObjectFactory();
    abstract function getSelectionFactory();
    abstract function getUpdateFactory();
}

class SpacePersistenceFactory extends PersistenceFactory {
    public function getCollection( array $raw ) {
        return new SpaceCollection( $raw, $this->getDomainObjectFactory() );
    }

    public function getDomainObjectFactory() {
        return new SpaceDomainObjectFactory();
    }

    public function getSelectionFactory() {
        return new SpaceSelectionFactory();
    }

    public function getUpdateFactory() {
        return new SpaceUpdateFactory();
    }
}

class VenuePersistenceFactory extends PersistenceFactory {
    public function getCollection( array $raw ) {
        return new VenueCollection( $raw, $this->getDomainObjectFactory() );
    }

    public function getDomainObjectFactory() {
        return new VenueDomainObjectFactory();
    }

    public function getSelectionFactory() {
        return new VenueSelectionFactory();
    }

    public function getUpdateFactory() {
        return new VenueUpdateFactory();
    }
}

class EventPersistenceFactory extends PersistenceFactory {
    public function getCollection( array $raw ) {
        return new EventCollection( $raw, $this->getDomainObjectFactory() );
    }

    public function getDomainObjectFactory() {
        return new EventDomainObjectFactory();
    }
    public function getSelectionFactory() {
        return new EventSelectionFactory();
    }

    public function getUpdateFactory() {
        return new EventUpdateFactory();
    }
}


?>
