<?php

namespace woo\domain;

require_once ( "woo/domain/DomainObject.php" );

class ObjectWatcher {
    private $all = array();
    private static $instance=null;

    private function __construct() {}

    static function instance() {
        if ( is_null(self::$instance) ) {
            self::$instance = new ObjectWatcher();
        }
        return self::$instance;
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
