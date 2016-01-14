<?php

interface IdentityObject {
    public function generateId();
}

trait IdentityTrait {
    public function generateId() {
        return uniqid();
    }
}

trait PriceUtilities {

    function calculateTax($price) {
        return ( ($this->getTaxRate() / 100) * $price );
    }

    abstract function getTaxRate();

}

trait TaxTools {
    static function calculateTax($price) {
        return 222;
    }
}

abstract class Service {
}

class UtilityService extends Service {
    use PriceUtilities {
    PriceUtilities::calculateTax as private;
    }

    private $price;

    function __construct($price) {
        $this->price = $price;
    }

    function getTaxRate() {
        return 17;
    }

    function getFinalPrice() {
        return ($this->price + $this->calculateTax($this->price));
    }
}   

function printIdentityObject(IdentityObject $obj) {
    print $obj->generateId() . "\n";
}

$u = new UtilityService(100);
print $u->getFinalPrice() . "\n";

?>
