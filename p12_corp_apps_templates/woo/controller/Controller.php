<?php

namespace woo\controller;

class Controller {

    private $applicationHelper;
    private function __() {}

    static function run() {
        $instance = new Controller();
        $instance->init();
        $instance->handleRequest();
    }

    function init() {
        $applictionHelper = 
            ApplicationHelper::$instance();
        $applicationHelper->init();
    }

    function handleRequest() {
        $request = \woo\base\ApplicationRegistry::getRequest();
        $cmd_r = new woo\command\CommandResolver();
        $cmd = $cmd_r->getCommand( $request );
        $cmd->execute( $request );
    }
}

class ApplicationHelper {
    private static $instance = null;
    private $config = "date/woo_options.xml";

    private function __construct() {}

    static function instance() {
        if ( is_null(self::$instance) ) {
                     self::$instance = new self();
        }
        return self::$instance;
    }

    function init() {
        $dsn = \woo\base\ApplicationRegistry::getDSN();
        if ( ! is_null( $dsn ) ) {
            return;
        }
        $this->getOptions();
    }

    private function getOptions() {
        $this->ensure( file_exists( $this->config ),
                       "Configuration file not found");
        $options = @SimpleXml_load_file( $this->config );
        $dsn = (string) $options->dsn;
        $this->ensure( $options instanceof SimpleXMLElement,
                       "Configuration file is broken");
        $this->ensure( $dsn, "DSN not found" );
        \woo\base\ApplicationRegistry::setDSN( $dsn );
    }

    private function ensure( $expr, $message ) {
        if ( ! $expr ) {
            throw new \woo\base\AppException( $message );
        }
    }
}

?>
