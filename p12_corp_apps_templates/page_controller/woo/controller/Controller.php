<?php

namespace woo\controller;

require("woo/base/Registry.php");
require("woo/base/Exceptions.php");
require("woo/controller/CommandResolver.php");

class Controller {

    private $applicationHelper;
    private function __construct() {}

    static function run() {
        $instance = new Controller();
        $instance->init();
        $instance->handleRequest();
    }

    function init() {
        $applicationHelper = \woo\controller\ApplicationHelper::instance();
        $applicationHelper->init();
    }

    function handleRequest() {
        $request = \woo\base\ApplicationRegistry::getRequest();
        $app_c = \woo\base\ApplicationRegistry::appController();
        
        while( $cmd = $app_c->getCommand( $request ) ) {
            $cmd->execute( $request );
        }
        $this->invokeView( $app_c->getView( $request ) );
    }

    function invokeView( $target ) {
        print "Invoking view! \n";
        include( "woo/view/$target.php" );
        exit;
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


class ControllerMap {
    private $viewMap      = array();
    private $forwardMap   = array();
    private $classrootMap = array();

    function addClassroot( $command, $classroot ) {
        $this->classrootMap[$command] = $classroot;
    }

    function getClassroot( $command ) {
        if ( isset( $this->classrootMap[$command] ) ) {
            return $this->classrootMap[$command];
        }
        return null;
    }

    function addView( $view, $command='default', $status=0 ) {
        $this->viewMap[$command][$status] = $view;
    }

    function getView( $command, $status ) {
        if ( isset( $this->viewMap[$command][$status] ) ) {
            return $this->viewMap[$command][$status];
        }
        return null;
    }

    function addForward( $command, $status=0, $newCommand ) {
        $this->forwardMap[$command][$status] = $newCommand;
    }

    function getForward( $command, $status ) {
        if ( isset( $this->forwardMap[$command][$status] ) ) {
            return $this->forwardMap[$command][$status];
        }
        return null;
    }
}

class AppController {
    private static $base_cmd = null;
    private static $default_cmd = null;
    private $controllerMap;
    private $invoked = array();

    function __construct( ControllerMap $map ) {
        $this->controllerMap = $map;
        if ( is_null(self::$base_cmd) ) {
            self::$base_cmd = new \ReflectionClass( "\woo\command\Command" );
            self::$default_cmd = new \woo\command\DefaultCommand();
        }
    }

    function reset() {
        $this->invoked = array();
    }

    function getView( Request $req ) {
        $view = $this->getResource( $req, "View" );
        return $view;
    }

    private function getForward( Request $req ) {
        $forward = $this->getResource( $req, "Forward" );
        if ( $forward ) {
            $req->setProperty( 'cmd', $forward );
        }
        return $forward;
    }

    private function getResource( Request $req, $res ) {
        $cmd_str = $req->getProperty( 'cmd' );
        $previous = $req->getLastCommand();
        var_dump($previous);
        $status = $previous->getStatus();
 
        if ( ! isset( $status) || ! is_int( $status ) ) { $status = 0; }
        $acquire = "get$res";
        $resource = $this->controllerMap->$acquire( $cmd_str, $status );

        if ( is_null( $resource ) ) {
            $resource = $this->controllerMap->$acquire( $cmd_str, 0 );
        }

        if ( is_null( $resource ) ) {
            $resource = $this->controllerMap->$acquire( 'default', $status );
        }

        if ( is_null( $resource ) ) {
            $resource = $this->controllerMap->$acquire( 'default', 0 );
        }
        return $resource;
    }

    function getCommand( Request $req ) {
        $previous = $req->getLastCommand();
    
        if ( ! $previous ) {
            $cmd = $req->getProperty('cmd');
            if ( is_null( $cmd ) ) {
                $req->setProperty('cmd', 'default');
                return self::$default_cmd;
            }
        } else {
            $cmd = $this->getForward( $req );
            if ( is_null( $cmd ) ) { return null; }
        }

        $cmd_obj = $this->resolveCommand( $cmd );
        if ( is_null( $cmd_obj ) ) {
            throw new \woo\base\AppException(
                "Command '$cmd' not found!"
            );
        }

        $cmd_class = get_class( $cmd_obj );
        if ( isset( $this->invoked[$cmd_class] ) ) {
            throw new \woo\base\AppException( "Cycling call!" );
        }

        $this->invoked[$cmd_class] = 1;
        return $cmd_obj;
    }

    function resolveCommand( $cmd ) {
        $classroot = $this->controllerMap->getClassroot( $cmd );
        $filepath = "woo/command/$classroot.php";
        $classname = "\woo\command\\$classroot";
        if ( file_exists( $filepath ) ) {
            require_once ( $filepath );
            if ( class_exists( $classname ) ) {
                $cmd_class = new \ReflectionClass($classname);
                if ($cmd_class->isSubClassOf( self::$base_cmd ) ) {
                    return $cmd_class->newInstance();
                }
            }
        }
        return null;
    }
}
?>
