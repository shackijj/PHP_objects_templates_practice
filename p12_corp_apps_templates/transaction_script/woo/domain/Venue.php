<?php

namespace woo\domain;
require_once( "woo/process/VenueManager.php" );

class Venue {
    private $id;
    private $name;

    function __construct( $id, $name ) {
        $manager = new \woo\process\VenueManager();
        $v_data = $manager->addVenue( $name , null );
        $v_id = $v_data['id'];

        $this->name = $name;
        $this->id = $v_id;
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }
}
?>
