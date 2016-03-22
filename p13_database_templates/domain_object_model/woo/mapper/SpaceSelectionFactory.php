<?php 

namespace woo\mapper;

require_once( "woo/mapper/SelectionFactory.php" );

class SpaceSelectionFactory extends SelectionFactory {
    function newSelection( IdentityObject $obj ) {
        $fields = implode( ',', $obj->getObjectFields() );
        $core = "SELECT $fields FROM space";
        list( $where, $values ) = $this->buildWhere( $obj );
        return array( $core." ".$where, $values );
    }
}
