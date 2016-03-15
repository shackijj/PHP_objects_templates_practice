<?php

namespace woo\mapper;

require_once( "woo/mapper/Mapper.php" );
require_once( "woo/mapper/Collections.php" );

class SpaceMapper extends Mapper {
    function __construct() {
        parent::__construct();
        $this->selectStmt =      self::$PDO->prepare(
                            "SELECT * FROM space WHERE id = ?");
        $this->updateStmt =      self::$PDO->prepare(
                            "UPDATE space SET name=?, id=?, venue=? WHERE id=?");
        $this->insertStmt =      self::$PDO->prepare(
                            "INSERT into space ( name, venue ) values ( ?, ? )");
        $this->selectAllStmt =   self::$PDO->prepare(
                            "SELECT * FROM space");
        $this->findByVenueStmt = self:: $PDO->prepare(
                            "SELECT * FROM space WHERE venue=?");
    }

    function getCollection( array $raw ) {
        return new SpaceCollection( $raw, $this );
    }

    protected function doCreateObject( array $array ) {
        $obj = new \woo\domain\Space( $array['id'], $array['name'] );
        $obj->setName( $array['name'] );
        $ven_mapper = new VenueMapper();
        $venue = $ven_mapper->find( $array['venue'] );

        $obj->setVenue( $venue );
        $event_mapper = new EventMapper();
        $event_collection = $event_mapper->findBySpaceId( $array['id'] );
        $obj->setEvents( $event_collection );
        return $obj;
    }

    protected function doInsert( \woo\domain\DomainObject $object ) {
        $venue = $object->getVenue();
        if ( ! $venue ) {
            throw new \woo\base\AppException(" Can't save without venue" );
        }
        $values = array( $object->getName(), $venue->getId() );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function targetClass() {
        return \woo\domain\Space::class;
    }

    function update( \woo\domain\DomainObject $object ) {
        $values = array( $object->getName(),
                         $object->getId(), $object->getId() );
        $this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }

    function findByVenue( $vid ) {
        $this->findByVenueStmt->execute( array($vid) );
        $factory  = $this->getFactory()->getDomainObjectFactory();
        return new SpaceCollection( $this->findByVenueStmt->fetchAll(), $factory );
    }

    function selectAllStmt() {
       return $this->selectAllStmt;
    }
}

?>
