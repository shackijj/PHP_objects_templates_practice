<?php

class Person {

    private $_name;
    private $_age;

    function __set( $property, $value ) {
        $method = "set{$property}";

        if ( method_exists( $this, $method ) ) {
            
            return $this->$method( $value );
        }
    }

    function setName( $name ) {
        $this->_name = $name;

        if( ! is_null( $name ) ) {
            $this->_name = strtoupper($this->_name);
        }
   }

    function setAge( $age ) {
        $this->_age = strtoupper($age);
    }
    /*
    function __get( $property ) {
        $method = "get{$property}";

        if ( method_exists( $this, $method ) ) {
            return $this->$method();
        }
    }

    function __isset( $property ) {
        $method = "get{$property}";
        return ( method_exists( $this, $method ) );
    } 

    function getName() {
        return "Ivan";
    }

    function getAge() {
        return 44;
    }
    */
}


$p = new Person();
$p->name = "Ivan";

?>   
