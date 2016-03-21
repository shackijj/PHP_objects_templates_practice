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
 
    <table>
    <?php
      foreach( $venues as $venue ) {
    ?>
      <tr>
        <td> <?php print $venue->getName(); ?></td>
      </tr>
    <?php
    }
    ?>
    </table>
  </body>
<html>
