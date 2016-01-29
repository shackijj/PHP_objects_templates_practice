<?php

abstract class Lesson {
    protected $duration;
    private $costStrategy;

    function __construct( $duration, CostStrategy $strategy ) {
        $this->duration = $duration;
        $this->costStrategy = $costtype;
    }

    function cost() {
        $this->costStrategy->cost($this);
    }

    function chargeType() {
        $this->costStartegy->chargeType($this);
    }   
}

class Lecture extends Lesson {}
class Seminar extends Lesson {}

abstract class CostStrategy {
    abstract public function cost();

    abstract public function chargeType();
}

$lecture = new Lecture( 5, Lesson::FIXED );
print "{$lecture->cost()} ({$lecture->chargeType()})\n";

$seminar = new Seminar( 3, Lesson::TIMED );
print "{$seminar->cost()} ({$seminar->chargeType()})\n";

?>
