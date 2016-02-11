<?php

namespace woo\controller;

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
        print "ApplicationHelper Init\n";
        $this->getOptions();
        $dsn = \woo\base\ApplicationRegistry::getDSN();
        if ( ! is_null( $dsn ) ) {
            return;
        }
    }

    private function getOptions() {
   
        $this->ensure( file_exists( $this->config ),
                       "Configuration file not found");
        $options = @SimpleXml_load_file( $this->config );
        $dsn = (string) $options->dsn;

        $this->ensure( $options instanceof \SimpleXMLElement,
                       "Configuration file is broken");
        $this->ensure( $dsn, "DSN not found" );
        \woo\base\ApplicationRegistry::setDSN( $dsn );

        print \woo\base\ApplicationRegistry::getDSN();

        $map = new ControllerMap();

        foreach( $options->control->view as $default_view ) {
            $stat_str = trim($default_view['status']);
            
            if ( empty($stat_str ) ) {
                $status = \woo\command\Command::statuses();
            } else {
                $status = \woo\command\Command::statuses( $stat_str );
            }
            $map->addView( (string) $default_view, 'default', $status );
        }
        
        foreach( $options->control->command as $command ) {
            
            if (! empty($command['name']) && $command->view ) {
                $command_name = trim($command['name']);
                $map->addView( (string) $command->view, $command_name);
                $map->addClassroot($command_name, (string) $command->classroot['name']);

                foreach($command->status as $cmdstat) {
                    $stat_str = trim( $cmdstat['value'] );
                    if ( empty($stat_str ) ) {
                        $status = \woo\command\Command::statuses();
                    } else {
                        $status = \woo\command\Command::statuses( $stat_str );
                    }
                    
                    $map->addForward( (string) $command_name, $status, (string) $cmdstat->forward );
                }
            }
        } 
        var_dump($map);
        \woo\base\ApplicationRegistry::setControllerMap( $map );    
    }

    private function ensure( $expr, $message ) {
        if ( ! $expr ) {
            throw new \woo\base\AppException( $message );
        }
    }
}

?>
