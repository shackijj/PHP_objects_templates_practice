<?php
namespace megaquiz\command;

/**
 * This is file summary
 *
 * @package command
 *
 */

/**
 * Define core functionality for commands.
 * Command classes perform specific tasks in a a system via
 * execute() method.
 *
 */
abstract class Command {
    /**
     * execute specific task
     * @param $context CommandContext Shared contextual data
     * @return bool false on failure, true on success
     */
    abstract function execute( CommandContext $context );
}


/**
 * Encapsulate data for passing to, from and between Commands.
 * CommandContext object is passed ti the command context.
 * blabla
 *
 * @see \megaquiz\command\Command::execute()    Bla
 */

class CommandContext {
    /**
    * The app name
    * used by various clients for error messages etc.
    *
    * @var string
     */
    public $applicationName;
    /**
     * Encapsulated Keys/Velues
     * This class is essesnsially a wrapper for this array
     *
     * @var array
     */
    private $params = array();
    /**
     * An error message
     *
     * @var string
     */
    private $error = "";

    function __construct() {
        $this->params = $_REQUEST;
    }

    function addParam( $key, $val ) {
        $this->params[$key] = $val;
    }

    function get( $key ) {
        if ( isset( $this->params[$key] ) ) {
            return $this->params[$key];
        }
        return null;
    }

    function setError( $error ) {
        $this->error = $error;
    }

    function getError() {
        return $this->error;
    }
}

