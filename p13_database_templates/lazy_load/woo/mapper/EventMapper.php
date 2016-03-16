<?php

namespace woo\mapper;

require_once( "woo/mapper/Mapper.php" );
require_once( "woo/mapper/Collections.php" );

class EventMapper extends Mapper {
    function __construct() {
        parent::__construct();
        $this->selectStmt =      self::$PDO->prepare(
                            "SELECT * FROM event WHERE id = ?");
        $this->updateStmt =      self::$PDO->prepare(
                            "UPDATE event SET name=?, id=?, space=?, start=?, duration=? WHERE id=?");
        $this->insertStmt =      self::$PDO->prepare(
                            "INSERT into event ( name, space ) values ( ?, ? )");
        $this->selectAllStmt =   self::$PDO->prepare(
                            "SELECT * FROM event");
        $this->findBySpaceStmt = self:: $PDO->prepare(
                            "SELECT * FROM event WHERE space=?");
    }

    function getCollection( array $raw ) {
        return new SpaceCollection( $raw, $this );
    }

    protected function doCreateObject( array $array ) {
        $obj = new \woo\domain\Space( $array['name'], $array['space'] );
        return $obj;
    }

    protected function doInsert( \woo\domain\DomainObject $object ) {
        $space = $object->getSpace();
        if ( ! $space ) {
            throw new \woo\base\AppException(" Can't save without space" );
        }
        $values = array( $object->getName(), $space->getId() );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function targetClass() {
        return \woo\domain\Event::class;
    }

    function update( \woo\domain\DomainObject $object ) {
        $space = $object->getSpace();
        $values = array( $object->getName(),
                         $object->getId(), 
                         $space->getId(), 
                         $object->getStart(),
                         $object->getDuration);
        $this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }

    function findBySpaceId( $sid ) {
<<<<<<< HEAD
        return new DeferredEventCollection( $this,
                                            $this->selectBySpaceStmt,
                                            array( $sid ) );  
=======
        return new DeferredEventCollection( $this, $this->selectStmt, array( $sid ) );
>>>>>>> lazy_load
    }

    function selectAllStmt() {
       return $this->selectAllStmt;
    }
}

?>
