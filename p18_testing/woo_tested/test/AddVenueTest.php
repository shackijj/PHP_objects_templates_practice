<?php

require_once("woo/base/Registry.php");
require_once("woo/controller/Controller.php");

class AddVenueTest extends PHPUnit_Framework_TestCase {
    function testAddVenueVanilla() {
        $output = $this->runCommand("AddVenue", array("venue_name"=>"bob"));
        self::AssertRegexp( "/added/", $output );
    }

    function runCommand( $command=null, array $args=null ) {
        ob_start();
        $request = \woo\base\ApplicationRegistry::getRequest();
        if ( ! is_null( $args ) ) {
            foreach( $args as $key => $val ) {
                $request->setProperty( $key, $val );
            }
        }

        if ( ! is_null( $command ) ) {
            $request->setProperty( 'cmd', $command );
        }
        woo\controller\Controller::run();
        $ret = ob_get_contents();
        ob_end_clean();
        return $ret;
    }
}
