<?php
    require_once( "woo/base/Registry.php" );
    $request = \woo\base\ApplicationRegistry::getRequest();
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
