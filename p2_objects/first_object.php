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

/*

$writer = new ShopProductWriter();
$product1 = new BookProduct("Dog's heart", "Michail", "Bulgakov", 5.99, 100);
$product2 = new CDProduct("The lost man", "Band", "DDT", 10.99, 60.33);

$writer->addProduct($product1);
$writer->addProduct($product2);
$writer->write();

*/

// part5 object tools in action


print_r( get_class_methods( 'CDProduct' ));

// dynamic call
$product = new CDProduct("The lost man", "Band", "DDT", 10.99, 60.33);
$method = "getTitle";

if ( in_array( $method, get_class_methods( $product ) ) ) {
    print $product->$method() . "\n";
}

if ( is_callable( array( $product, $method ) ) ) {
    print $product->$method() . "\n";
}

if ( method_exists( $product, $method ) ) {
    // Warning! Method could be private or protected but method_exists will return true anyway
    print $product->$method() . "\n";
}

print_r( get_class_vars( 'CDProduct' ) );
print get_parent_class( 'CDProduct' ) . "\n";
if ( is_subclass_of( $product, 'ShopProduct') ) {
    print "CDProduct is sublcass of ShopProduct\n";
}

// Method call

call_user_func(array($product, "setDiscount"), 20);
// all args as array
call_user_func_array(array($product, "setDiscount"), array(20));

?>
