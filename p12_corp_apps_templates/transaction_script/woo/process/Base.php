<?php
namespace woo\process;

require_once( "woo/base/Registry.php" );

abstract class Base {
    static $DB;
    static $statements = array();

    function __construct() {
        $dsn = \woo\base\ApplicationRegistry::getDSN();
        if ( is_null( $dsn ) ) {
            throw new \woo\base\AppException(
                "Can't get DSN!");
        }
        self::$DB = new \PDO( $dsn, 'woo', 'sql' );
        self::$DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    function prepareStatement( $statement ) {
        if ( isset( self::$statements[$statement] ) ) {
             return self::$statements[$statement];
        }
        $stmt_handle = self::$DB->prepare($statement);
        self::$statements[$statement] = $stmt_handle;
        return $stmt_handle;
    }

    public function doStatement( $statement, array $values ) {
        $sth = $this->prepareStatement( $statement );
        $sth->closeCursor();
        $db_result = $sth->execute( $values );
        return $sth;
    }
}
?>
