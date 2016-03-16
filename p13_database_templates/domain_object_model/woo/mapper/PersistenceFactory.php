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
}

class SpacePersistenceFactory extends PersistenceFactory {
    public function getCollection( array $raw ) {
        return new SpaceCollection( $raw, $this->getDomainObjectFactory() );
    }

    public function getDomainObjectFactory() {
        return new SpaceDomainObjectFactory();
    }
}

class VenuePersistenceFactory extends PersistenceFactory {
    public function getCollection( array $raw ) {
        return new VenueCollection( $raw, $this->getDomainObjectFactory() );
    }

    public function getDomainObjectFactory() {
        return new VenueDomainObjectFactory();
    }
}

class EventPersistenceFactory extends PersistenceFactory {
    public function getCollection( array $raw ) {
        return new EventCollection( $raw, $this->getDomainObjectFactory() );
    }

    public function getDomainObjectFactory() {
        return new EventDomainObjectFactory();
    }
}


?>
