<?php

class WooDB extends SQLite3
{

    function __construct()
    {
        $this->open('woo.db');
    }
}

$db = new WooDB();

$db->exec('CREATE TABLE venue ( id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT )');
$db->exec('CREATE TABLE space ( id integer primary key autoincrement, venue int default null,  name text)');
$db->exec('CREATE TABLE event ( id int primary key, space int default null, start long, duration int, name text)');

?>
