<?php

namespace woo\domain;

class Space {
    private $id;
    private $name;

    function __construct( $id, $name, $venue_id ) {
        $this->name = $name;
        $this->id = $id;
        $this->venue_id = $venue_id
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }
}
?>

