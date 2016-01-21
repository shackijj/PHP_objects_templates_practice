<?php

class ShopProduct {
    private $title;
    private $producerMainName;
    private $producerFirstName;
    protected $price;
    protected $discount;

    public function __construct( $title, $firstName, 
                                 $mainName, $price ) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    public function getProducer() {
        return "{$this->producerFirstName} " 
               ."{$this->producerMainName}";
    }
    
    public function getSummaryLine() {
        $base = "$this->title ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function getProducerMainName() {
        return $this->getProducerMainName();
    }

    public function getProductionFirstName() {
        return $this->getProductionFirstName();
    }

    public function setDiscount($num) {
        $this->discount = $num;
    }

    public function getPrice() {
        return ($this->price - $this->discount);
    }
}

class CDProduct extends ShopProduct {
    private $playLength;
    public static $coverUrl;

    public function __construct($title, $firstName, $mainName, 
                                $price, $playLength) {

        parent::__construct($title, $firstName, $mainName, $price);
        $this->playLength = $playLength;
    }
    

    public function getPlayLength() {
        return $this->playLength;
    }

    public function getSummaryLine() {
        $base  = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        $base .= ": Play time - {$this->playLength}";
        return $base;
    }
}

class BookProduct extends ShopProduct {
    private $numPages;

    public function __construct($title, $firstName, 
                                $mainName, $price, $numPages) {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPages = $numPages;
    }

    public function getNumberOfPages() {
        return $this->numPages;
    }

    public function getSummaryLine() {
        $base  = parent::getSummaryLine();
        $base .= ": {$this->numPages} p.\n";
        return $base;
    }

    public function getPrice() {
        return $this->price;
    }
}

class ShopProductWriter {

    private $products = array();

    public function addProduct(ShopProduct $shopProduct) {
        $this->products[] = $shopProduct;
    } 

    public function write() {
        $str = "";

        foreach ($this->products as $shopProduct) {
            $str .= "{$shopProduct->getTitle()}: "
                    .$shopProduct->getProducer()
                ." ({$shopProduct->getPrice()})\n";
        }
        print $str;
    }
}

class ReflectionUtil {

    static function getClassSource( ReflectionClass $class ) {
        $path = $class->getFileName();
        $from = $class->getStartLine();
        $to = $class->getEndLine();

        return self::getSource($path, $from, $to);
    }

    static function getMethodSource( ReflectionMethod $method ) {
        $path = $method->getFileName();
        $from = $method->getStartLine();
        $to = $method->getEndLine();

        return self::getSource($path, $from, $to);
    }    
    
    private static function getSource( $filename, $from, $to ) {
        if ( is_file($filename) ) {
            $lines = @file( $filename );
            $len = $to - $from + 1;
            return implode( array_slice( $lines, $from - 1, $len ) );
        } else {
            throw new Exception("$path is not a file");
        }
    }

    static function classData( ReflectionClass $class ) {
        $details = "";
        $name = $class->getName();
        if ( $class->isUserDefined() ) {
            $details .= "$name is defined by user\n";
        }
    
        if ( $class->isInternal() ) {
            $details .= "$name is a built-in class\n";
        }
    
        if ( $class->isInterface() ) {
            $details .= "$name is an interface\n";
        }
    
        if ( $class->isAbstract() ) {
            $details .= "$name is an abstract class\n";
        }
    
        if ( $class->isFinal() ) {
            $details .= "$name is final class\n";
        }
    
        if ( $class->isInstantiable() ) {
            $details .= "$name - it's possible to create an instance\n";
        } else {
            $details .= "$name - it's impossible to create an instance\n";
        }
    
        if ( $class->isCloneable() ) {
            $details .= "$name -- is cloneable\n";
        } else {
            $details .= "$name -- is not cloneable\n";
        }
    
        return $details;
    }
    
    static function methodData( ReflectionMethod $method ) {
        $details = "";
        $name = $method->getName();
        if ( $method->isUserDefined() ) {
            $details .= "$name is an user defined method\n";
        } 
    
        if ( $method->isInternal() ) {
            $details .= "$name is a buit-in method\n";
        }
     
        if ( $method->isAbstract() ) {
            $details .= "$name is an abstract method\n";
        }
    
        if ( $method->isPublic() ) {
            $details .= "$name is a public method\n";
        }
    
        if ( $method->isProtected() ) {
            $details .= "$name is a protected method\n";
        }
    
        if ( $method->isPrivate() ) {
           $details .= "$name is a private method\n";
        }
    
        if ( $method->isStatic() ) {
            $details .= "$name is a static method\n";
        }
    
        if ( $method->isFinal() ) {
            $details .= "$name is a final method\n";
        }
    
        if ( $method->isConstructor() ) {
            $details .= "$name is a constuctor\n";
        }
    
        if ( $method->returnsReference() ) {
            $details .= "$name returns a reference not a value\n";
        }

        return $details;
    }

    static function argData( ReflectionParameter $arg ) {
        $details = "";
        $declaringclass = $arg->getName();
        $name = $arg->getName();
        $class = $arg->getClass();
        $position = $arg->getPosition();
        $details .= "\$$name is in $position position\n";
        if ( ! empty( $class ) ) {
            $classname = $class->getName();
            $details .= "\$$name has to be object of $classname\n";
        }
        if ( $arg->isPassedByReference() ) {
            $details .= "\$$name is passed by reference\n";
        }
        if ( $arg->isDefaultValueAvailable() ) {
            $def = $arg->getDefaultValue();
            $default .= "\$$name is $def by default\n";
        }
        return $details;
    }
}
  
$prod_class = new ReflectionClass('CDProduct');
// Reflection::export($prod_class);
// print classData( $prod_class );
// print ReflectionUtil::getClassSource( $prod_class );

$methods = $prod_class->getMethods();

foreach( $methods as $method ) {
    print ReflectionUtil::methodData( $method );
    print ReflectionUtil::getMethodSource( $method );
    $params = $method->getParameters();
    print "Parameters\n";
    foreach( $params as $param ) {
        print "\t" . ReflectionUtil::argData( $param );
    }
    print "\n ---- \n";
}

?>
