<?php
class Person {
    public $name;

    function __construct( $name ) {
        $this->name = $name;
    }
}

interface Module {
    function execute();
}

class FtpModule implements Module {
    function setHost( $host ) {
        print "FtpModule::setHost(): $host\n";
    }

    function setUser( $user ) {
        print "FtpModule::setUser(): $user\n";
    }

    function execute() {
       //Work
    }
}

class PersonModule implements Module {
    function setPerson( Person $person ) {
        print "PersonModule::setPerson(): {$person->name}\n";
    }

    function execute() {
        //Work
    }
}

class ModuleRunner {
    private $configData = array(
        "PersonModule" => array( 'person' => 'bob'),
        "FtpModule"    => array( 'host' => 'example.com',
                                 'user' => 'anon')
    );

    private $modules = array();

    function init() {
        $interface = new ReflectionClass('Module');
        foreach( $this->configData as $moduleName => $params ) {
            $module_class = new ReflectionClass( $moduleName );
            if ( ! $module_class->isSubclassOf( $interface ) ) {
                throw new Exception("Unknown type of module: $moduleName");
            }

            $module = $module_class->newInstance();
            

            foreach( $module_class->getMethods() as $method ) {
                $this->handleMethod( $module, $method, $params );
            }
            array_push( $this->modules, $module );
        }
    }

    function handleMethod( Module $module, 
        ReflectionMethod $method, $params) {
        $name = $method->getName();
        $args = $method->getParameters();

        if ( count( $args ) != 1 || substr($name, 0, 3) != "set" ) {
            print "$name can't be set up by first condition. args count: ". count( $args )  . "\n";
            return false;
        }

        $property = strtolower( substr( $name, 3 ) );
        if ( ! isset(  $params[$property]  ) ) {
            print "$name can't be set up by second condition!\n";
            return false;
        }

        $arg_class = $args[0]->getClass();
        if ( empty( $arg_class ) ) {
            $method->invoke( $module, $params[$property] );
        } else {
            $method->invoke( $module,
                $arg_class->newInstance( $params[$property] ) );
        }
    }

    function executeAll() {
        foreach($this->modules as $module) {
            $module->execute();
        }
    }
}
        
$test = new ModuleRunner();
$test->init();
$test->executeAll();
?>
