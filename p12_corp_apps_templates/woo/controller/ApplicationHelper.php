<?php

namespace woo\controller\ApplicationHelper;

class ApplicationHelper {
    function getOptions() {
        if ( ! file_exists( "data/woo_options.xml" ) ) {
            throw new \woo\base\AppException(
                 "Parameters file not found!" );
        }
        $options = simplexml_load_file( "data/woo_options.xml" );
        $dsn = (string) $options->dsn;
        //
    }
}

?>
