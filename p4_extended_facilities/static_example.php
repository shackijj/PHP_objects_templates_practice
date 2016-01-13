<?php

class StaticExample {
    static public $aNum = 0;

    static public function sayHello() {
        self::$aNum++;
        print "Hello! (" . self::$aNum . ")\n";
    }
}

StaticExample::sayHello();

?>
