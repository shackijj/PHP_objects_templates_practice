<?php
    require_once( "woo/base/Registry.php" );
    $request = \woo\base\ApplicationRegistry::getRequest();
?>

<html>
 <head>
  <title>Add Venue</title>
 </head>
 <body>
  <h1>Add Venue</h1>

  <table>
   <tr>
    <td>
     <?php 
     print $request->getFeedbackString("</td></tr><tr><td>");
     ?>
    </td>
    </tr>
  </table>

  <form action="index.php" method="get">
    <input type="hidden" name="cmd" value="AddVenue" />
    <input type="hidden" name="submitted" value="yes" />
    <input type="text" name="venue_name" />
  </form>

 </body>
</html>
