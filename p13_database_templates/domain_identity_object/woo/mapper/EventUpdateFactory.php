<?php

namespace woo\mapper;

require_once( "woo/mapper/UpdateFactory.php" );

class EventUpdateFactory extends UpdateFactory {
    function newUpdate( \woo\domain\DomainObject $obj ) {
        $class = get_class( $obj );
        if ( $class !== "woo\domain\Event" ) {
             throw new \Exception( "Wrong type {$class}" );
        }
        $id = $obj->getId();
        $cond = null;
        $values['name'] = $obj->getName();
        
        $space = $obj->getSpace();
        if ( $space ) {
            $values['space'] = $space->getId();
        }

        $value['duration'] = $obj->getDuration();
        $value['start'] = $obj->getStart();

        if ( $id > -1 ) {
            $cond['id'] = $id;
        }
        return $this->buildStatement( "venue", $values, $cond );
    }
}

?>
