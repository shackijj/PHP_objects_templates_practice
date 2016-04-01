<?php 

class User {
    private $name;
    private $mail;
    private $pass;
    private $failed;

    function __construct( $name, $mail, $pass ) {
        if ( strlen( $pass ) < 5 ) {
            throw new Exception (
                "Length of pass should be at least 5.");
        }

        $this->name = $name;
        $this->pass = $pass;
        $this->mail = $mail;
    }

    function getName() {
        return $this->name;
    }

    function getMail() {
        return $this->mail;
    }

    function getPass() {
        return $this->pass;
    }

    function failed( $time ) {
        $this->failed = $time;
    }
}
?>
