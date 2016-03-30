<?php

require_once("UserStore.php");

class UserStoreTest extends PHPUnit_Framework_TestCase {
    private $store;

    public function setUp() {
        $this->store = new UserStore();
    }

    public function tearDown() {
    }

    public function testGetUser() {
        $this->store->addUser("bob mod", "a@b.com", "12345");
        $user = $this->store->getUser("a@b.com");
        $this->assertEquals( $user->getMail() , "a@b.com" );
        $this->assertEquals( $user->getName() , "bob mod" );
        $this->assertEquals( $user->getPass(), "12345" );
    }

    public function testAddUser_ShortPass() {
        try {
            $this->store->addUser( "bob williams", "bob@example.com", "ff" );
            $this->fail("Short password exception expected.");
        } catch ( Exception $e ) {}
    }

    public function testAddUser_duplicate() {
        try {
            $ret = $this->store->addUser("bob mob", "a@b.com", "123456");
            $ret = $this->store->addUser("bob stevens", "a@b.com", "123456");
            self::fail( "Here should be exception" );
        } catch ( Exception $e ) {
            $const = $this->logicalAnd(
                        $this->logicalNot( $this->attributeEqualTo("name", "bob stevens") ),
                        $this->isType('object')
                    );
            self::AssertThat( $this->store->getUser("a@b.com"), $const );
        }
    }
}

?>
