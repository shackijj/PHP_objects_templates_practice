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
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getTdnEncoder();
    abstract function getContactEncoder();
    abstract function getFooterText();

}

class BloggsCommsManager extends CommsManager {
    function getHeaderText() {
        return "BloggsCal upper colonitule\n";
    }

    function getFooterText() {
        return "BloggsCal lower colontitule\n";
    }

    function getApptEncoder() {
        return new BloggsApptEncoder();
    }

    function getTdnEncoder() {
        return new BloggsTdnEncoder();
    }

    function getContactEncoder() {
        return new BloggsContactEncoder();
    }
}

$mgr = new BloggsCommsManager();
print $mgr->getHeaderText();
print $mgr->getApptEncoder()->encode();
print $mgr->getFooterText();

?>
