<?php
namespace woo\command;

class CustomCommand extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $request->addFeedback( "Custome Welcome to Woo!" );
        include( "woo/view/main.php" );
    }
}

?>   
