<?php

require_once("userthing/persist/UserStore.php");

class Validator {
    private $store;

    function __construct( UserStore $store ) {
        $this->store = $store;
    }

    public function validateUser( $mail, $pass ) {
        if ( ! is_object( $user = $this->store->getUser( $mail ) ) ) {
            return false;
        }

        if ( $user->getPass() == $pass ) {
            return true;
        }

        $this->store->notifyPasswordFailure( $mail );
        return false;
    }
}
