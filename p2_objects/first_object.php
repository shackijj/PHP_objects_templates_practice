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

$writer = new ShopProductWriter();
$product1 = new BookProduct("Dog's heart", "Michail", "Bulgakov", 5.99, 100);
$product2 = new CDProduct("The lost man", "Band", "DDT", 10.99, 60.33);

$writer->addProduct($product1);
$writer->addProduct($product2);
$writer->write();

?>
