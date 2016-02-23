<?php

namespace woo\controller;
require_once( "woo/base/Registry.php" );

abstract class PageController {

    abstract function process();

    function forward( $resource ) {
        include( $resource );
        exit(0);
    }

    function getRequest() {
        return \woo\base\ApplicationRegistry::getRequest();
    }
}

?>            
