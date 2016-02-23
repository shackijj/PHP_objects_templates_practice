<?php

namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );
require_once( "woo/domain/Space.php" );

class Venue extends DomainObject {
    private $name;
    private $spaces;

    function __construct( $id = null, $name = null ) {
        $this->name = $name;
        $this->spaces = self::getCollection("\woo\domain\Space");
        parent::__construct( $id );
    }

    function setSpaces( SpaceCollection $spaces ) {
        $this->spaces = $spaces;
    }

    function getSpaces() {
        if ( is_null( $this->spaces ) ) {
            $finder = self::getFinder( "woo\domain\Space" );
            $this->spaces = $finder->findByVenue( $this->getId() );
        }
        return $this->spaces;
    }

    function addSpace(Space $space) {
        $this->spaces->add( $space );
        $space->setVenue( $this );
        $this->markDirty();
    }

    function setName( $name_s ) {
        $this->name = $name_s;
        $this->markDirty();
    }

    function getName() {
        return $this->name;
    }
}

?>
