<?php

namespace woo\domain;
require_once( "woo/domain/HelperFactory.php" );

abstract class DomainObject {
    private $id;

    function __construct( $id = null ) {
        $this->id = $id;
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

    function collection() {
        return self::getCollection( get_class( $this ) );
    }
}

?>
