<?php

namespace woo\domain;
require_once( "woo/process/VenueManager.php" );

class Space {
    private $id;
    private $name;
    private $venue_id;

    function __construct( $name, $venue_id ) {
        $manager = new \woo\process\VenueManager();
        $s_obj = $manager->addSpace( $name, $venue_id );
        $this->name = $name;
        $this->id = $s_obj['id'];
        $this->venue_id = $venue_id;
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }
}
?>

