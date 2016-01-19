<?php

class Account {
    public $balance;

    function __construct( $balance ) {
        $this->balance = $balance;
    }
}

class Person {
    private $id;
    private $age;
    private $name;
    public  $account;

    function __construct( $name, $age, Account $account){
        $this->name = $name;
        $this->age = $age;
        $this->account = $account;
    }

    function setId( $id ) {
        $this->id = $id;
    }

    function __destruct() {
        if ( ! empty($this->id) ) {
            print "Saving object person...\n";
        }
    }

    function __clone() {
        //called for a new cloned instance
        $this->id = 0;
        $this->account = clone $this->account;
    }
}

$person = new Person( "Peter", 44, new Account(20) );
$person->setId(343);

$person2 = clone $person;
$person->account->balance += 10;

print_r($person);
print_r($person2);

?>
