<?php

namespace woo\mapper;

require_once( "woo/mapper/UpdateFactory.php" );

class SpaceUpdateFactory extends UpdateFactory {
    function newUpdate( \woo\domain\DomainObject $obj ) {
        $class = get_class( $obj );
        if ( $class !== "woo\domain\Space" ) {
             throw new \Exception( "Wrong type {$class}" );
        }
        $id = $obj->getId();
        $cond = null;
        $values['name'] = $obj->getName();

        $venue = $obj->getVenue();
        if ( $venue ) {
            $value['venue'] = $venue->getId();
        }

        if ( $id > -1 ) {
            $cond['id'] = $id;
        }
        return $this->buildStatement( "venue", $values, $cond );
    }
}

?>
