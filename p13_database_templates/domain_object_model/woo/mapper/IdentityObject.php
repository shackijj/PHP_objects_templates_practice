<?php

namespace woo\mapper;
require( "woo/mapper/Field.php" );

class IdentityObject {
    protected $currentfield = null;
    protected $fields = array();
    private $and = null;
    private $enforce = array();

    function __construct( $field = null, array $enforce = null ) {
        if ( ! is_null( $enforce ) ) {
            $this->enforce = $enforce;
        }
        if ( ! is_null( $field ) ) {
            $this->field( $field );
        }
    }

    function getObjectFields() {
        return $this->enforce;
    }

    function field( $fieldname ) {
        if ( ! $this->isVoid() && $this->currentfield->isIncomplete() ) {
            throw new \Exception( "Incomplete field." );
        }
        $this->enforceField( $fieldname );
        if ( isset( $this->fields[$fieldname] ) ) {
            $this->currentfield = new Field( $fieldname );
        } else {
            $this->currentfield = new Field( $fieldname );
            $this->fields[$fieldname] = $this->currentfield;
        }
        return $this;
    }

    function isVoid() {
        return empty( $this->fields );
    }

    function enforceField( $fieldname ) {
        if ( ! in_array( $fieldname, $this->enforce ) &&
             ! empty( $this->enforce ) ) {
             $forcelist = implode( ', ', $this->enforce );
             throw new \Exception( "{$fieldname} is not correct field
                 {$forcelist}");
        }
    }

    function lt( $value ) {
        return $this->operator( "<", $value );
    }

    function gt( $value ) {
        return $this->operator( ">", $value );
    }

    function eq( $value ) {
        return $this->operator( "=", $value );
    }

    private function operator( $symbol, $value ) {
        if ( $this->isVoid() ) {
            throw new \Exception( "Field not defined" );
        }
        $this->currentfield->addTest( $symbol, $value );
        return $this;
    }

    function getComps() {
        $comparisons = array();
        foreach( $this->fields as $key => $field ) {
            // Whar is ret? It's undefined
            $comparisons = array_merge( $ret, $field->getComps() );
        }
        return $comparisons;
    }
}
