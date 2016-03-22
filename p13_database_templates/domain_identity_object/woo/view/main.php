<?php
    require_once( "woo/view/ViewHelper.php" );
    $request = \woo\view\ViewHelper::getRequest();
?>
<html>
<head>
    <title>Woo! It is the Woo Application</title>
</head>

<body>
    <table>
        <tr>
            <td>
                <?php print $request->getFeedbackString(); ?>
            </td>
        </tr>
    <table>
</body>

</html>
