<?php

abstract class Unit {
    abstract function bombardStrength();
}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
}

class LaserCannonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

class Army {
    private $units = array();
    private $armies = array();

    function addArmy( Army $army ) {
        array_push( $this->armies, $army );
    }

    function addUnit( Unit $unit ) {
        array_push( $this->units, $unit );
    }

    function bombardStrength() {
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret += $unit->bombardStrength();
        }

        // Duplication!
        foreach( $this->armies as $army ) {
            $ret += $army->bombardStrength();
        }
 
        return $ret;
    }
}  
