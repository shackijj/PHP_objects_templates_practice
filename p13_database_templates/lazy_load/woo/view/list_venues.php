<?php
    require_once( "woo/view/ViewHelper.php" );
    $request = \woo\view\ViewHelper::getRequest();
    $venues = $request->getObject('venues');
?>

<html>
  <head>
    <title>List Venues</title>
  </head>

  <body>

    <h1>Venues</h1>
 
    <?php
      foreach( $venues as $venue ) {
    ?>
      <div> 
      <h3> <?php print $venue->getName(); ?></h3>
      <?php $spaces = $venue->getSpaces(); ?>
      <ul>
          <?php foreach( $spaces as $space ) { ?>
              <li> <?php print $space->getName(); ?> </li>
             
          <?php } ?>
      </ul>
      </div>
    <?php
    }
    ?>
    </table>

<html>
