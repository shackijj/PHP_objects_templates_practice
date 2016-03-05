<?php

namespace woo\domain;
require_once( "woo/domain/HelperFactory.php" );
require_once( "woo/domain/ObjectWatcher.php" );

abstract class DomainObject {
    private $id = -1;

    function __construct( $id = null ) {
        if ( is_null( $id ) ) {
            $this->markNew();
        } else {
            $this->id = $id;
        }
    }

    function setId( $id ) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    static function getCollection( $type=null ) {
        if ( is_null( $type ) ) {
            // late static binding
            return HelperFactory::getCollection( get_called_class() );
        }
        return HelperFactory::getCollection( $type );
    }

    static function getFinder( $type=null ) {
        if ( is_null( $type ) ) {
            return HelperFactory::getFinder( get_called_class() );
        }
        return HelperFactory::getFinder( $type );
    }

    function markNew() {
        ObjectWatcher::addNew( $this );
    }

    function markDeleted() {
        ObjectWatcher::addDelete( $this );
    }


    function markDirty() {
        ObjectWatcher::addDirty( $this );
    }

    function markClean() {
        ObjectWatcher::addClean( $this );
    }

    function finder() {
        return self::getFinder( get_class( $this ) );
    }

    function collection() {
        return self::getCollection( get_class( $this ) );
    }
}

?>
