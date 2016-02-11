<?php

namespace woo\view;

require_once( "woo/controller/Request.php" );

class ViewHelper {
    static function getRequest() {
        return \woo\base\ApplicationRegistry::getRequest();
    }
}

?>
