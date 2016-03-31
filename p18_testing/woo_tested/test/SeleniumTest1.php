<?php

class seleniumtest extends PHPUnit_Framework_TestCase {
    protected function setUp() {
        $host = "http://127.0.0.1:4444/wd/hub";
        $capabilities = array( WebDriverCapabilityType::BROWSER_NAME => 'firefox' );
        $this->webDriver = RemoteWebDriver::create( $host, $capabilities );
    }
    public function testAddVenue() {
        $this->webDriver->get("http://localhost?cmd=AddVenue");
        $venel = $this->webDriver->findElement( 
                WebDriverBy::name("venue_name") );
        $venel->sendKeys("my_test_venue");
        $venel->submit();
        
        $tdel = $this->webDriver->findElement(
                WebDriverBy::xpath("//td[1]"));
        $this->assertRegexp("/'my_test_venue' added/", 
                $tdel->getText());

        $spacel = $this->webDriver->findElement(
                WebDriverBy::name("space_name"));
        $spacel->sendKeys( "my_test_space" );
        $spacel->submit();

        $el = $this->webDriver->findElement(
                WebDriverBy::xpath("//td[1]"));
        $this->assertRegexp("/'my_test_space' is added/", 
                $el->getText());

    }
}
?>
