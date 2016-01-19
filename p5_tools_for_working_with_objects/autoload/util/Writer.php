<?php
namespace util {
    class Writer {
        function __construct() {
            print "Creating instance of " . __NAMESPACE__ . " Writer\n";
        }
    }
}

namespace {
    class util_Writer {
        function __construct() {
            print "Creating instance of writer\n";
        }
    }
}
?>
