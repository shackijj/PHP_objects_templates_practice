<?php

require_once "lesson.php";

class RegistrationMgr {
    function register( Lesson $lesson ) {

        $notifier = Notifier::getNotifier();
        $notifier->inform( "New lesson: cost - ({$lesson->cost()})" );
    }
}

abstract class Notifier {

    static function getNotifier() {
        if ( rand(1,2) === 1 ) {
            return new MailNotifier();
        } else {
            return new TextNotifier();
        }
    }

    abstract function inform( $message );
}

class MailNotifier extends Notifier {

    function inform( $message ) {
        print "Email notification: {$message}\n";
    }
}

class TextNotifier extends Notifier {

    function inform( $message ) {
        print "Text notification: {$message}\n";
    }
}

$lesson1 = new Seminar( 4, new TimedCostStrategy() );
$lesson2 = new Lecture( 4, new FixedCostStrategy() );

$mgr = new RegistrationMgr();
$mgr->register( $lesson1 );
$mgr->register( $lesson2 );
?>
