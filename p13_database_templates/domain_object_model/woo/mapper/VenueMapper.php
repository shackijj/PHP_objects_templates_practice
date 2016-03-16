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

    protected function targetClass() {
        return \woo\domain\Venue::class;
    }

    function selectStmt() {
        return $this->selectStmt;
    }
  
    function selectAllStmt() {
        return $this->selectAllStmt;
    } 
}

?>
