<?php

abstract class Unit {
    function getComposite() {
        return null;
    }

    abstract function bombardStrength();
}

abstract class CompositeUnit extends Unit {
    private $units = array();
    
    function getComposite() {
        return $this;
    }

    protected function units() {
        return $this->units;
    }

    function removeUnit( Unit $unit ) {
        $this->units = array_udiff( $this->units, array( $unit ),
            function( $a, $b ) { return ($a === $b) ? 0 : 1; } );
    }

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true ) ) {
            return;
        }
        $this->units[] = $unit;
    }
}

class Army extends CompositeUnit {}
class TroopCarrier extends CompositeUnit {}


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

class UnitScript {
    private $comp;

    static function joinExisting( Unit $newUnit, Unit $occupyingUnit ) {
        if ( ! is_null( $comp = $occupying_unit->getComposite() ) ) {
            $comp->addUnit( $newUnit );
        else {
            $comp = new Army();
            $comp->addUnit( $occupyingUnit );
            $comp->addUnit( $newUnit );
        }
        return $comp;
    }
}

$main_army = new Army();
$main_army->addUnit( new Archer() );
$main_army->addUnit( new LaserCannonUnit() );

$sub_army = new Army();
$sub_army->addUnit( new Archer() );
$sub_army->addUnit( new Archer() );
$sub_army->addUnit( new Archer() );

$main_army->addUnit( $sub_army );

print "Bombard Strength: {$main_army->bombardStrength()}\n";
