<?php

namespace woo\mapper;

require_once( "woo/mapper/Mapper.php" );
require_once( "woo/mapper/DomainObjectFactory.php" );

abstract class Collection implements \Iterator {
    protected $dofact;
    protected $total = 0;
    protected $raw = array();

    private $result;
    private $pointer = 0;
    private $objects = array();

    function __construct( array $raw = null, 
        \woo\mapper\DomainObjectFactory $dofact = null ) {
        if ( ! is_null( $raw ) && ! is_null( $dofact ) ) {
            $this->raw = $raw;
            $this->total = count( $raw );
        }
        $this->dofact = $dofact;
    }

    function add( \woo\domain\DomainObject $object ) {
        $class = $this->targetClass();
        if ( ! ($object instanceof $class ) ) {
            throw new Exception( "It's collection {$class}" );
        }
        $this->notifyAccess();
        $this->objects[$this->total] = $object;
        $this->total++;
    }

    abstract function targetClass();

    protected function notifyAccess() {
        return null;
    }

    protected function getRow( $num ) {
        $this->notifyAccess();
        if ( $num >= $this->total || $num < 0 ) {
            return null;
        }
    
        if ( isset( $this->objects[$num] ) ) {
            return $this->objects[$num];
        }

        if ( isset( $this->raw[$num] ) ) {
            $this->objects[$num] = $this->dofact->createObject( $this->raw[$num] );
            return $this->objects[$num];
        }
    }
    
    public function rewind() {
        $this->pointer = 0;
    }

    public function current() {
        return $this->getRow( $this->pointer );
    }

    public function key() {
        return $this->pointer;
    }

    public function next() {
        $row = $this->getRow( $this->pointer );
        if ( $row ) { $this->pointer++; }
        return $row;
    }

    public function valid() {
        return ( ! is_null( $this->current() ) );
    }

    public function count() {
        return count( $this->objects );
    }

    public function elementAt( $num ) {
        return $this->getRow($num);
    }

    public function deleteAt( $num ) {
        if ( isset( $this->objects[$num] ) ) {
            unset( $this->objects[$num] );
        }
    }
}  
