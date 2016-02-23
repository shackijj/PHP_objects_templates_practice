<?php

namespace woo\domain;

require_once ( "woo/domain/DomainObject.php" );

class ObjectWatcher {
    private $all    = array();
    private $dirty  = array();
    private $new    = array();
    private $delete = array();
    
    private static $instance=null;

    private function __construct() {}

    static function instance() {
        if ( is_null(self::$instance) ) {
            self::$instance = new ObjectWatcher();
        }
        return self::$instance;
    }

    static function addDelete( DomainObject $obj ) {
        $inst = self::instance();
        $inst->delete[$self->globalKey( $obj )] = $obj;
    }

    static function addDirty( DomainObject $obj ) {
        $inst = self::instance();
        // in array desc
        if ( ! in_array( $obj, $inst->new, true ) ) {
            $inst->dirty[$inst->globalKey( $obj )] = $obj;
        }
    }

    static function addNew( DomainObject $obj ) {
        $inst = self::instance();
        $inst->new[] = $obj;
    }

    static function addClean( DomainObject $obj ) {
        $inst = self::instance();
        unset( $inst->delete[$inst->globalKey( $obj )] );
        unset( $inst->dirty[$inst->globalKey( $obj )] );
        $inst->new = array_filter( $inst->new,
            function( $a ) use ( $obj ) { return !($a === $obj); }
        );
    }

    function performOperations() {
        foreach( $this->dirty as $key=>$obj ) {
            $obj->finder()->update( $obj );
            print "Updating {$obj->getName()}\n";
        }
        foreach( $this->new as $key=>$obj ) {
            print "Inserting {$obj->getName()}\n";
            $obj->finder()->insert( $obj );
        }
        $this->dirty = array();
        $this->new   = array();
    }    

    function globalKey( DomainObject $obj ) {
        $key = get_class( $obj ) . "." . $obj->getId();
        return $key;
    }

    static function add( DomainObject $obj ) {
        $inst = self::instance();
        $inst->all[$inst->globalKey( $obj )] = $obj;
    }

    static function exists( $classname, $id ) {
        $inst = self::instance();
        $key = "{$classname}.{$id}";
        if ( isset( $inst->all[$key] ) ) {
            return $inst->all[$key];
        }
        return null;
    }
}
