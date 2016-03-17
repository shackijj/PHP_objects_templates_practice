<?php

namespace woo\mapper;

require_once( "woo/mapper/IdentityObject.php" );

$idobj = new IdentityObject();

$idobj->field("name")->eq("The good show");

print_r( $idobj->getComps() );
