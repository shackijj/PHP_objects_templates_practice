<?php

abstract class Lesson {
    private $duration;
    private $costStrategy;

    function __construct( $duration, CostStrategy $strategy ) {
        $this->duration = $duration;
        $this->costStrategy = $strategy;
    }

    function cost() {
        return $this->costStrategy->cost($this);
    }

    function chargeType() {
        return $this->costStrategy->chargeType();
    }

    function getDuration() {
        return $this->duration;
    }
}

class Lecture extends Lesson {}
class Seminar extends Lesson {}

abstract class CostStrategy {
    abstract function cost( Lesson $lesson );
    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy {
    function cost( Lesson $lesson ) {
        return ( $lesson->getDuration() * 5 );
    }

    function chargeType() {
        return "Timed cost";
    }
}
 
class FixedCostStrategy extends CostStrategy {
    function cost( Lesson $lesson ) {
        return 30;
    }

    function chargeType() {
        return "Fixed cost";
    }
}

$lessons[] = new Seminar(4, new TimedCostStrategy() );
$lessons[] = new Lecture(4, new FixedCostStrategy() );

foreach ($lessons as $lesson) {
    print "Lesson duration: {$lesson->getDuration()}. ";
    print "Lesson cost: {$lesson->cost()}. ";
    print "Cost type: {$lesson->chargeType()}\n";
}
