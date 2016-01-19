<?php
namespace {
    class Lister {
        public static function helloWorld() {
            print "Hello from global namespace\n";
        }
    }
}

namespace com\getinstance\util {

    class Lister {
        public static function helloWorld() {
            print "Hello from " . __NAMESPACE__ . "\n";
        }
    }

    Lister::helloWorld();
    \Lister::helloWorld();
}

?>
