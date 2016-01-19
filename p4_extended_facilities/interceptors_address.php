<?php

class Address {

    private $number;
    private $street;

    function __construct( $maybenumber, $maybestreet=null ) {
        if ( is_null($maybestreet) ) {
            $this->streetaddress = $maybenumber;
        } else {
            $this->number = $maybenumber;
            $this->street = $maybestreet;
        }
    }

    function __set( $property, $value ) {
        if ( $property === "streetaddress" ) {
            if ( preg_match( "/^(\d+.*?)[\s,]+(.+)$/", $value, $matches) ) {
                $this->number = $matches[1];
                $this->street = $matches[2];
            }
        }
    }

    function __get( $property ) {
        if ( $property === "streetaddress" ) {
            return $this->number . " " . $this->street;
        }
    }
}

$address = new Address( "44lb Bakers Street" );
print "Address: {$address->streetaddress} \n";

$address = new Address(15, "Albert Mews");
print "Address: {$address->streetaddress} \n";

$address->streetaddress = "34, West 24th Avenue";
print "Address: {$address->streetaddress} \n";
?>
