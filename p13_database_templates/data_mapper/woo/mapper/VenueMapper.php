<?php

namespace woo\mapper;

require_once( "woo/mapper/Mapper.php" );

class VenueMapper extends Mapper {
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare(
                            "SELECT * FROM venue WHERE id = ?");
        $this->updateStmt = self::$PDO->prepare(
                            "UPDATE venue SET name=?, id=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare(
                            "INSERT into venue ( name ) values ( ? )");
        $this->selectAllStmt = self::$PDO->prepare(
                            "SELECT * FROM venue");
    }

    function getCollection( array $raw ) {
        return new VenueCollection( $raw, $this );
    }

    protected function doCreateObject( array $array ) {
        $obj = new \woo\domain\Venue( $array['id'] );
        $obj->setName( $array['name'] );
        $space_mapper = new SpaceMapper();
        $space_collection = $space_mapper->findByVenue( $array['id'] );
        $obj->setSpaces( $space_collection );
        return $obj;
    }

    protected function doInsert( \woo\domain\DomainObject $object ) {
        $values = array( $object->getName() );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    function update( \woo\domain\DomainObject $object ) {
        $values = array( $object->getName(),
                         $object->getId(), $object->getId() );
        $this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }
  
    function selectAllStmt() {
        return $this->selectAllStmt;
    }

}

?>
