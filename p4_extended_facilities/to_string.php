<?php

class Person {

    function getName() { return "Ivan"; }
    function getAge() { return 44; }

    function __toString() {
        $desc  = $this->getName();
        $desc .= " (is " . $this->getAge() . " years old)\n";
        return $desc;
    }
}

$p = new Person();
print $p;
?>
