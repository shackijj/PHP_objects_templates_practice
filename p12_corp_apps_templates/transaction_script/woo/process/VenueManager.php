<?php

namespace woo\process;

require_once( "woo/process/Base.php" );

class VenueManager extends Base {

    static $add_venue = "INSERT INTO venue
                         ( name )
                         VALUES ( ? )";
    static $add_space = "INSERT INTO space
                         ( name, venue )
                         VALUES ( ?, ?)";
    static $check_slot = "SELECT id, name
                          FROM event
                          WHERE space = ?
                          AND (start + duration) > ?
                          AND (start < ? )";
    static $add_event = "INSERT INTO event 
                         ( name, space, start, duration )
                         VALUES ( ?, ?, ?, ? )";


    function addSpace( $name, $venue_id ) {
        $spacedata = array();
        $spacedata['space'] = array( $name, $venue_id );
        $this->doStatement( self::$add_space, $spacedata['space'] );
        $s_id = self::$DB->lastInsertId();
        $spacedata['id'] = $s_id;
        return $spacedata;
    }

    function addVenue( $name, $space_array ) {
        $venuedata = array();
        $venuedata['venue'] = array( $name );
        $this->doStatement( self::$add_venue, $venuedata['venue'] );
        $v_id = self::$DB->lastInsertId();
        $venuedata['id'] = $v_id;
        $venuedata['spaces'] = array();
        foreach ( $space_array as $space_name ) {
            $values = array( $space_name, $v_id );
            $this->doStatement( self::$add_space, $values );
            $s_id = self::$DB->lastInsertId();
            array_unshift( $values, $s_id );
            $venuedata['spaces'][] = $values;
        }
        return $venuedata;
    }

    function bookEvent( $space_id, $name, $time, $duration ) {
        $values = array( $space_id, $time, ($time + $duration) );
        $stmt = $this->doStatement( self::$check_slot, $values, false );
        if ( $result = $stmt->fetch() ) {
            throw new \woo\base\AppException( 
                "Already booked! Try another time" );
        }
        $this->doStatement( self::$add_event,
           array( $name, $space_id, $time, $duration ));
    }
}
