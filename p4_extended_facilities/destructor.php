<?php

class Person {
    private $id;
    private $age;
    private $name;

    function __construct( $name, $age ) {
        $this->name = $name;
        $this->age = $age;
    }

    function setId( $id ) {
        $this->id = $id;
    }

    function __destruct() {
        if ( ! empty($this->id) ) {
            print "Saving object person...\n";
        }
    }
}

$person = new Person("Ivan", 44);
$person->setId(343);
unset($person);

?>
