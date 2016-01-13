<?php

interface Chargeable {
    public function getPrice();
}

class ShopProduct implements Chargeable {

    const AVAILABLE = 0;
    const OUT_OF_STOCK = 1;

    private $id = 0;
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

    public function setID($id) {
        $this->id = $id;
    }

    public static function getInstance($id, PDO $pdo) {
        
        $stmt = $pdo->prepare("select * from products where id=?");
        $result = $stmt->execute(array($id));
   
        $row = $stmt->fetch();

        if(empty($row)) { return null; }

        if ($row['type'] === "book") {
            $product = new BookProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['numpages']
            );
        } else if ($row['type'] === "cd") {
            $product = new CDProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['numpages']
            );
        } else {
            $product = new ShopProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price']
            );
        }
        
        $product->setID($row['id']);
        $product->setDiscount($row['discount']);
        return $product;
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

abstract class ShopProductWriter {

    protected $products = array();

    public function addProduct(ShopProduct $shopProduct) {
        $this->products[] = $shopProduct;
    } 

    abstract public function write(); 
}

class XmlProductWriter extends ShopProductWriter {

    public function write() {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
            $writer->startElement("products");       
            foreach($this->products as $shopProduct) {
                $writer->startElement("product");
                $writer->writeAttribute("title", $shopProduct->getTitle());    
                 
                    $writer->startElement("summary");
                    $writer->text($shopProduct->getSummaryLine());
                    $writer->endElement(); // summary

               $writer->endElement(); // product
            }
            $writer->endElement(); // products
        $writer->endDocument();
        print $writer->flush();
    }
}

class TextProductWriter extends ShopProductWriter {

    public function write() {
        $str = "Products:\n";
        foreach($this->products as $shopProduct) {
            $str .= $shopProduct->getSummaryLine() . "\n";
        }
        print $str;
    }
}

// Client code

$dsn = "sqlite://home/kirill/learn_php/products.db";
$pdo = new PDO($dsn, null, null);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$obj = ShopProduct::getInstance(1, $pdo);

$xml_writer = new XmlProductWriter();
$xml_writer->addProduct($obj);
$xml_writer->write();


?>
