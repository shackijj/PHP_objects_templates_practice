<?php

namespace woo\domain;

class Space {
    private $id;
    private $name;
    private $venue_id;

    function __construct( $name, $venue_id ) {
        $this->name = $name;
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

