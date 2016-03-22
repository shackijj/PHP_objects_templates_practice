<?php

namespace woo\mapper;

require_once( "woo/mapper/UpdateFactory.php" );

class VenueUpdateFactory extends UpdateFactory {
    function newUpdate( \woo\domain\DomainObject $obj ) {
        $class = get_class( $obj );
        if ( $class !== "woo\domain\Venue" ) {
             throw new \Exception( "Wrong type {$class}" );
        }
        $id = $obj->getId();
        $cond = null;
        $values['name'] = $obj->getName();
        if ( $id > -1 ) {
            $cond['id'] = $id;
        }
        return $this->buildStatement( "venue", $values, $cond );
    }
}

?>
