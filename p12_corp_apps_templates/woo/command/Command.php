<?php

namespace woo\command;

abstract class Command {
    final function __construct() {}

    function execute ( \woo\controller\Request $request ) {
        $this->doExecute( $request );
    }

    abstract function doExecute( \woo\controller\Request $request );
}

?>   
