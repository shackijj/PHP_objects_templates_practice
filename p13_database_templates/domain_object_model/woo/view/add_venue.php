<?php
    require_once( "woo/view/ViewHelper.php" );
    $request = \woo\view\ViewHelper::getRequest();
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

  <form method="post">
    <input type="text" name="venue_name" />
    <input type="submit" value="submit" />
  </form>

 </body>
</html>
