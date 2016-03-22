<?php

namespace woo\controller;

class Request {
    private $objects = array();
    private $properties = array();
    private $feedback = array();
    private $appreg;
    private $lastCommand;

    function __construct() {
        $this->init();
        \woo\base\RequestRegistry::setRequest( $this );
    }

    function init() {
        if ( isset( $_SERVER['REQUEST_METHOD'] ) ) {
            $this->properties = $_REQUEST;
            return ;
        }
        foreach ( $_SERVER['argv'] as $arg ) {
            if ( strpos( $arg, '=' ) ) {
                list( $key, $val ) = explode( "=", $arg );
                $this->setProperty( $key, $val );
            }
        }
    }

    function getProperty( $key ) {
        if ( isset( $this->properties[$key] ) ) {
            return $this->properties[$key];
        }
        return null;
    }

    function setProperty( $key, $val ) {
        $this->properties[$key] = $val;
    }

    function addFeedback( $msg ) {
        array_push( $this->feedback, $msg );
    }

    function setCommand( \woo\command\Command $command ) {
        $this->lastCommand = $command;
    }

    function getObject( $name ) {
        if ( isset( $this->objects[$name] ) ) {
            return $this->objects[$name];
        } 
        return null;
    }

    function setObject( $name, $obj ) {
        $this->objects[$name] = $obj;
    }

    function getLastCommand() {
        return $this->lastCommand;
    }

    function getFeedback() {
        return $this->feedback;
    }

    function getFeedbackString( $separator="\n" ) {
        return implode( $separator, $this->feedback );
    }
}
