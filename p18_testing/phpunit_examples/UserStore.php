<?php

class UserStore {
    private $users = array();

    function addUser( $name, $mail, $pass ) {
        if ( isset( $this->users[$mail] ) ) {
            throw new Exception(
                    "User {$mail} had been already registered.");
        }

        if ( strlen( $pass ) < 5 ) {
            throw new Exception(
                    "Password's length must be at least 5.");
        }
        
        $this->users[$mail] = new User( $name, $mail, $pass );

        return true;
    }

    function notifyPasswordFailure( $mail ) {
        if ( isset( $this->users[$mail] ) ) {
            $this->users[$mail]->failed( time() );
        }
    }

    function getUser( $mail ) {
        if ( isset($this->users[$mail]) ) {
            return $this->users[$mail];
        }
        return null;
    }
}

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
