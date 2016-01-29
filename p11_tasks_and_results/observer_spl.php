<?php

class Login implements SplSubject {

    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS   = 2;
    const LOGIN_ACCESS       = 3;
   
    private $storage;
    private $status; 

    function __construct() {
        $this->storage = new SplObjectStorage();
    }

    function attach( SplObserver $observer ) {

        $this->storage->attach($observer);

    }

    function detach( SplObserver $observer ) {

        $this->storage->detach($observer);    

    }

    function notify() {
        foreach( $this->storage as $obs ) {
            $obs->update( $this );
        }
    }

    function handleLogin( $user, $pass, $ip ) {
        $isvalid = false;
        switch( rand(1, 3) ) {
            case 1:
                $this->setStatus( self::LOGIN_ACCESS, $user, $ip );
                $isvalid = true;
                break;
            case 2:
                $this->setStatus( self::LOGIN_WRONG_PASS, $user, $ip );
                $isvalid = false;
                break;
            case 3:
                $this->setStatus( self::LOGIN_USER_UNKNOWN, $user, $ip );
                $isvalid = false;
                break;
            }
        $this->notify();
        return $isvalid;
    }

    private function setStatus( $status, $user, $ip ) {
        $this->status = array( $status, $user, $ip );
    }

    function getStatus() {
        return $this->status;
    }
}

abstract class LoginObserver implements SplObserver {
    private $login;

    function __construct( Login $login ) {
        $this->login = $login;
        $login->attach( $this );
    }

    function update( SplSubject $observable ) {
        if ( $observable === $this->login ) {
            $this->doUpdate( $observable );
        }
    }

    abstract function doUpdate( Login $login );
}

class SecurityMonitor extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus();
        
        if ( $status[0] == Login::LOGIN_WRONG_PASS ) {
            print __CLASS__ . ":\t Send mail to system administartor \n";
        }
    }
}

class GeneralLogger extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus();
        
        print __CLASS__ . "\t Registration in system log\n";
    }
}

class PartnershipTool extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus();

        print __CLASS__ .
        ":\t Sending cookie file if IP address in the list\n";
    }
}

$login = new Login();
new SecurityMonitor( $login );
$login->handleLogin("Test", "Test", "10.200.123.1");
