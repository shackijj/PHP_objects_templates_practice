<?php

abstract class ApptEncoder {
    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder {

    function encode() {
        return "Data about meeting is encoded in the BloggsCal format \n";
    }
}

class MegaApptEncoder extends ApptEncoder {
    function encode() {
        return "Data about meeting is encoded in MagaCal \n";
    }
}

abstract class CommsManager {
    const APPT    = 1;
    const TTD     = 2;
    const CONTACT = 3;

    abstract function getHeaderText();
    abstract function getContactEncoder();
    abstract function make();
}

class BloggsCommsManager extends CommsManager {
    function getHeaderText() {
        return "BloggsCal upper colonitule\n";
    }

    function getFooterText() {
        return "BloggsCal lower colontitule\n";
    }

    function make( $flag_int ) {
        switch( $flag_int ) {
            case self::APPT:
                return new BloggsApptEncoder();
            case self::CONTACT:
                return new BloggsContactEncoder();
            case self::TTD:
                return new BloggsTtdEncoder();
        }
    }
}

$mgr = new BloggsCommsManager();
print $mgr->getHeaderText();
print $mgr->getApptEncoder()->encode();
print $mgr->getFooterText();

?>
