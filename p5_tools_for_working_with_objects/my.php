<?php
namespace main;
require_once "useful/Outputter.php";
use com\getinstance\util\Debug as uDebug;


class Debug {
    static function helloWorld() {
        print "Hello from class main\Debug\n";
    }
}

Debug::helloWorld();
uDebug::helloWorld();

?>
