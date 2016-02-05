<?php 

namespace woo\base;

require( "woo/controller/Request.php" );

abstract class Registry {
    abstract protected function get( $key );
    abstract protected function set( $key, $val );
}

class RequestRegistry extends Registry {
    private $value = array();
    private static $instance = null;

    private function __construct() {}

    static function instance() {
        if ( is_null(self::$instance) ) {
                     self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get( $key ) {
        if ( isset( $this->values[$key] ) ) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set( $key, $value ) {
        $this->values[$key] = $value;
    }

    static function getRequest() {
        $inst = self::$instance();
        if ( is_null( $inst->get("request") ) ) {
            $inst->set('request', new \woo\controller\Request() );
        }

        return $inst->get("request");
    }
}

class SessionRegistry extends Registry {
    private static $instance = null;
   
    private function __construct() {
        session_start();
    }

    static function instance() {
        if ( is_null(self::$instance) ) {
                     self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get( $key ) {
        if ( isset( $_SESSION[__CLASS__][$key] ) ) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }

    protected function set( $key, $val ) {
        $_SESSION[__CLASS__][$key] = $val;
    }

    function setDSN( $dsn ) {
        self::instance()->set( "dsn", $dsn );
    }

    function getDSN() {
        return self::$instance()->get("dsn");
    }
}

class ApplicationRegistry extends Registry {
    private static $instance = null;
    private $freezedir = "date";
    private $values    = array();
    private $mtimes    = array();
    public $request;

    private function __construct() {}

    static function instance() {
        if ( is_null(self::$instance) ) {
                     self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get( $key ) {
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        if (file_exists( $path ) ) {
            clearstatcache();
            $mtime = filemtime( $path );
            if ( ! isset($this->mtimes[$key]) ) {
                $this->mtimes[$key] = 0;
            }
            if ( $mtime > $this->mtimes[$key] ) {
                $data = file_get_contents( $path );
                $this->mtimes[$key] = $mtime;
                return ($this->values[$key] = unserialize( $data ));
            }
        }
        if ( isset($this->values[$key]) ) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set( $key, $val ) {
        $this->values[$key] = $val;
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        var_dump( $path );
        file_put_contents( $path, serialize( $val ) );
        $this->mtimes[$key] = time();
    }

    function setDSN( $dsn ) {
        self::instance()->set( "dsn", $dsn );
    }

    function getDSN() {
        return self::instance()->get("dsn");
    }


    static function getRequest() {
        $inst = self::instance();
        if ( is_null( $inst->request ) ) {
            $inst->request = new \woo\controller\Request();
        }

        return $inst->request;
    }
}

class MemApplicationRegistry extends Registry {
    private static $instance = null;
    private $values = array();
    private $id;

    function __construct() {}

    static function instance() {
        if ( is_null(self::$instance) ) {
                     self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get( $key ) {
        return \apc_fetch( $key );
    }

    protected function set( $key, $val ) {
        return \apc_store( $key, $value );
    }

    function setDSN( $dsn ) {
        self::instance()->set( "dsn", $dsn );
    }

    function getDSN() {
        return self::$instance()->get("dsn");
    }
}

?>
