<?php

namespace woo\command;

class CommandResolver {
    private static $base_cmd = null;
    private static $default_cmd = null;

    function __construct() {
        if ( is_null( self::$base_cmd ) ) {
            self::$base_cmd = new \ReflectionClass( "\woo\command\Command" );
            self::$default_cmd = new DefaultCommand();
        }
    }

    function getCommand( \woo\controller\Request $request ) {
        $cmd = $request->getProperty( 'cmd' );
        $sep = DIRECTORY_SEPARATOR;
        if ( ! cmd ) {
            return self::$default_cmd;
        }
        $cmd = str_replace( array('.' . $sep), "", $cmd );
        $filepath = "woo{$sep}command{$sep}{$cmd}.php";
        $classname = "woo\\command\\$cmd";
        if ( file_exists( $filepath ) ) {
            @require_once( $filepath );
            if ( $cmd_class->isSubClassOf( self::$base_cmd ) ) {
                 return $cmd_class->newInstance();
            } else {
                $request->addFeedback( "Object Command of command '$cmd' not found" );
            }
        }
        $request->addFeedback( "Command 'cmd' not found" );
        return clone self::$default_cmd;
    }
}
