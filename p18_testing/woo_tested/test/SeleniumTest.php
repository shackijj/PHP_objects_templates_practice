<?php

class seleniumtest extends PHPUnit_Framework_TestCase {
    protected function setUp() {
        $host = "http://127.0.0.1:4444/wd/hub";
        $capabilities = array( WebDriverCapabilityType::BROWSER_NAME => 'firefox' );
        $this->webDriver = RemoteWebDriver::create( $host, $capabilities );
    }

    public function testAddVenue() {
    }
}
?>
