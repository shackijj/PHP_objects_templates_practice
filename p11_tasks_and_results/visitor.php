<?php

abstract class Unit {

    protected $depth;

    function getComposite() {
        return null;
    }

    abstract function bombardStrength();

    function accept ( ArmyVisitor $visitor ) {
        $method = "visit" . get_class( $this );
        $visitor->$method( $this );
    }

    protected function setDepth( $depth ) {
        $this->depth = $depth;
    }

    function getDepth() {
        return $this->depth;
    }
}

abstract class CompositeUnit extends Unit {
    private $units = array();
    
    function getComposite() {
        return $this;
    }

    protected function units() {
        return $this->units;
    }

    function bombardStrength() {
        $res = 0;
        foreach( $this->units as $unit ) {
            $res += $unit->bombardStrength();
        }
        return $res;
    }

    function removeUnit( Unit $unit ) {
        $this->units = array_udiff( $this->units, array( $unit ),
            function( $a, $b ) { return ($a === $b) ? 0 : 1; } );
    }

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true ) ) {
            return;
        }
        $unit->setDepth($this->depth+1);
        $this->units[] = $unit;
    }
    
    function accept( ArmyVisitor $visitor ) {
        parent::accept( $visitor );
        foreach ( $this->units as $thisunit ) {
            $thisunit->accept( $visitor );
        }
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

abstract class ArmyVisitor {
    abstract function visit( Unit $node );

    function visitArcher( Archer $node ) {
        $this->visit( $node );
    }

    function visitCavalry( Cavalry $node ) {
        $this->visit( $node );
    }

    function visitLaserCannonUnit( LaserCannonUnit $node ) {
        $this->visit( $node );
    }

    function visitTroopCarrierUnit( TroopCarrierUnit $node ) {
        $this->visit( $node );
    }

    function visitArmy( Army $node ) {
        $this->visit( $node );
    }
}

class TextDumpArmyVisitor extends ArmyVisitor {
    private $text = "";

    function visit( Unit $node ) {
        $txt = "";
        $pad = 4 * $node->getDepth();
        $txt .= sprintf( "%{$pad}s", "" );
        $txt .= get_class($node) . ": ";
        $txt .= "Fire power: " . $node->bombardStrength() . "\n";
        $this->text .= $txt;
    }

    function getText() {
        return $this->text;
    }
}

class TaxCollectionVisitor extends ArmyVisitor {
    private $due;
    private $report = "";

    function visit( Unit $node ) {
        $this->levy( $node, 1);
    }

    function visitArcher( Archer $node ) {
        $this->levy( $node, 2);
    }

    function visitTroopCarrierUnit( TroopCarrierUnit $node ) {
        $this->levy( $node, 5);
    }

    private function levy( Unit $unit, $amount ) {
        $this->report .= "Tax for " . get_class( $unit );
        $this->report .= ": $amount\n";
        $this->due += $amount;
    }

    function getReport() {
        return $this->report;
    }

    function getTax() {
        return $this->due;
    }
}   

class UnitScript {
    private $comp;

    static function joinExisting( Unit $newUnit, Unit $occupyingUnit ) {
        if ( ! is_null( $comp = $occupying_unit->getComposite() ) ) {
            $comp->addUnit( $newUnit );
        } else {
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

$textdump = new TextDumpArmyVisitor();
$main_army->accept( $textdump );
print $textdump->getText();

$taxcollector = new TaxCollectionVisitor();
$main_army->accept( $taxcollector );
print $taxcollector->getReport() . "\n";
print "TOTAL: ";
print $taxcollector->getTax() . "\n";
?>
