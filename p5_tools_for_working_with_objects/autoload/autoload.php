<?php

function straithIncludeWithCase($classname) {

    $file = "{$classname}.php";
    
    print "{$classname} Trying to require fail {$file} \n";
    if( file_exists( $file ) ) {
        require_once( $file );
    }
}

function replaceUnderscores ($classname) {
    $path = str_replace("_", DIRECTORY_SEPARATOR, $classname);
    print "{$classname} Trying replaceUnderscores...{$path}.php ";
    if ( file_exists( "{$path}.php" ) ) {
        require_once("{$path}.php");
        print "Success\n";
    } else {
        print "Fail: file not exists\n";
    }
}

function namespaceAutoload ($classname) {
    print "{$classname} Trying namespaceAutoload...";
    if ( preg_match( '/\\\\/', $classname ) ) {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    } else {
        $path = "{$classname}.php";
    }
    
    print $path . " ";

    if (file_exists( "{$path}.php") ) {
        print "Success\n";
        require_once("{$path}.php");
    } else {
        print "Fail\n";
    }
}

spl_autoload_register("straithIncludeWithCase");
spl_autoload_register("replaceUnderscores");
spl_autoload_register("namespaceAutoload");

$x = new util\Writer();
$y = new util_Writer();
$z = new Writer();
$a = new \util\Writer();


?>
