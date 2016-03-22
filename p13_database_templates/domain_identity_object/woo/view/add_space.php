<?php
    require_once( "woo/view/ViewHelper.php" );
    $request = \woo\view\ViewHelper::getRequest();
    $venue = $request->getObject('venue');
?>


<html>
  <head>
    <title>Add space to the venue '<?php echo $venue->getName() ?>'</title>
  </head>

  <body>

    <h1>Add space to the venue '<?php echo $venue->getName(); echo $venue->getId();?>'</h1>
 
    <table>
      <tr>
        <td>
        <?php print $request->getFeedbackString("</td></tr><td><tr>"); ?>
        </td>
      </tr>
    </table>

    <form method="post">
      <input type="text"
             value="<?php print $request->getProperty( 'space_name' ); ?>"
             name="space_name" />
      <input type="hidden" name="venue_id"
             value="<?php print $venue->getId(); ?>" />
      <input type="hidden" name="cmd" value="AddSpace">
      <input type="submit" value="submit" />
    </form>

  </body>
<html>
