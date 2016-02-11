<?php

namespace woo\domain;

class Venue {
    private $id;
    private $name;

    function __construct( $id, $name ) {
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
