<?php

namespace woo\mapper;

require_once( "woo/base/Registry.php" );
require_once( "woo/base/Exceptions.php" );
require_once( "woo/domain/ObjectWatcher.php" );
require_once( "woo/mapper/DomainObjectFactory.php" );
require_once( "woo/mapper/PersistenceFactory.php" );

abstract class Mapper {
    protected static $PDO;

    function __construct() {
        if ( ! isset(self::$PDO) ) {
            $dsn = \woo\base\ApplicationRegistry::getDSN();
            if ( is_null( $dsn ) ) {
                throw new \woo\base\AppException( "DSN not defined." );
            }
            self::$PDO = new \PDO( $dsn );
            self::$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }    
    }

    function find( $id ) {
        $old = $this->getFromMap( $id );
        if ( ! is_null( $old ) ) { return $old; }

        $this->selectStmt()->execute( array( $id ) );
        $array = $this->selectStmt()->fetch();
        $this->selectStmt()->closeCursor();
        if ( ! is_array( $array ) ) { return null; }
        if ( ! isset( $array['id'] ) ) { return null; }
        $object = $this->createObject( $array );
        $object->markClean();
        return $object;
    }

    function findAll() {
        $this->selectAllStmt()->execute( array() );
        $factory = $this->getFactory();
        return $factory->getCollection( $this->selectAllStmt()->fetchAll( \PDO::FETCH_ASSOC ) );
    }

    function createObject( $array ) {
        $factory = $this->getFactory()->getDomainObjectFactory();
        return $factory->createObject( $array );
    }

    function getFactory() {
        return PersistenceFactory::getFactory( $this->targetClass() );
    }

    function insert( \woo\domain\DomainObject $obj ) {
        $this->doInsert( $obj );
        $this->addToMap( $obj );
        $obj->markClean();
    }

    private function getFromMap( $id ) {
        return \woo\domain\ObjectWatcher::exists(
            $this->targetClass(), $id );
    }

    private function addToMap( \woo\domain\DomainObject $obj ) {
        return \woo\domain\ObjectWatcher::add( $obj );
    }

    abstract function update( \woo\domain\DomainObject $object );
    protected abstract function doInsert( \woo\domain\DomainObject $object );
    protected abstract function selectStmt();
    protected abstract function selectAllStmt();

}

?>
