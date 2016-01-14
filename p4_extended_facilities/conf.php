<?php

class XmlException extends Exception {
    private $error;

    function __construct( LibXmlError $error ) {
        $shortfile = basename( $error->file );
        $msg  = "[{$shortfile}, string {$error->line}, ";
        $msg .= "column {$error->column}] {$error->message}";
        $this->error = $error;
        parent::__construct( $msg, $error->code );

    }

    function getLibXmlError() {
        return $this->error;
    }
}

class FileException extends Exception { }
class ConfException extends Exception { }

class Conf {
    private $file;
    private $xml;
    private $lastmatch;

    function __construct( $file ) {
        $this->file = $file;
        if( ! file_exists( $file ) ) {
            throw new FileException("File '$file' not found");
        }

        $this->xml = simplexml_load_file($file, null, LIBXML_NOERROR);
        if( ! is_object($this->xml) ) {
            throw new XmlException( libxml_get_last_error() );
        }
   
        print gettype( $this->xml );
        $matches = $this->xml->xpath("/conf");
        if( ! count($matches) ) {
            throw new ConfException( "Root element not found." );
        }

    }

    function write() {
        if( ! is_writable( $this->file ) ) {
            throw new Exception("File '{$this->file}' is not writable");
        }
        file_put_contents($this->file, $this->xml->asXML());
    }

    function get( $str ) {
        $matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");
        if ( count( $matches ) ) {
            $this->lastmatch = $matches[0];
            return (string) $matches[0];
        }

        return null;
    }

    function set( $key, $value ) {
        if( ! is_null($this->get($key)) ) {
            $this->lastmatch[0] = $value;
            return;
        }

        $conf = $this->xml->conf;
        $this->xml->addChild( 'item', $value )->addAttribute( 'name', $key );
    }
}

class Runner {
    static function init() {
        try {
            $fh = fopen("./log.txt", "a");
            fputs( $fh, "Begining...\n");

            $conf = new Conf( dirname(__FILE__) . "/exaample.xml" );
            print "user: " . $conf->get('user') . "\n";
            print "host: " . $conf->get('host') . "\n";
            $conf->set("pass", "newpass");
            $conf->write();
        } catch ( FileException $e ) {
            fputs( $fh, "File exception\n" );
        } catch ( XmlException $e ) {
            //Something wrong with xml 
            fputs( $fh, "Error in xml code\n" );
        } catch ( ConfXml $e ) {
            // Wrong config
            fputs( $fh, "Configuration error\n" );
        } catch ( Exception $e ) {
            fputs( $fh, "Other error\n" );
        } finally {
            fputs( $fh, "End\n");
            fclose( $fh );
        }
    }
}

Runner::init();
