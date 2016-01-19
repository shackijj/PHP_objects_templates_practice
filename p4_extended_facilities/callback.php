<?php

class Product {
    public $name;
    public $price;

    function __construct( $name,  $price ) {
        $this->name = $name;
        $this->price = $price;
    }
}

class Mailer {
    function doMail( $product ) {
        print " Packing ({$product->name})\n";
    }
}

class Totalizer {
    static function warnAmount( $amt ){
        $count = 0;
        return function ( $product ) use ($amt, &$count ) {
                   $count += $product->price;
                   print " sum: $count\n";

                   if ($count > $amt ) {
                       print " Ammount of sale: {$count}\n";
                   }
               };
    }
}


class ProcessSale {
    private $callbacks;

    function registerCallback( $callback ) {
        if ( ! is_callable( $callback ) ) {
            throw new Exception( "Callback function not callable!" );
        }

        $this->callbacks[] = $callback;
    }

    function sale( $product ) {
        print "{$product->name}: processing...\n";

        foreach( $this->callbacks as $callback ) {
            call_user_func( $callback, $product );
        }
    }
}

// Old versions
// $logger = create_function('$product', 'print "Writing ... ({$product->name})\n";' );
// PHP5.3+
$logger = function ($product) {
              print " Writing ({$product->name})\n";
          };

$processor = new ProcessSale();

$processor->registerCallback( $logger );
$processor->registerCallback( array( new Mailer(), "doMail") );
$processor->registerCallback( Totalizer::warnAmount(8) );

$processor->sale( new Product("Shoes", 6) );
$processor->sale( new Product("Cofee", 6) ); 
