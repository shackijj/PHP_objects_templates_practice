<?php

namespace woo\command;
require("woo/command/Command.php");

class CustomCommand extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $request->addFeedback( "Custome Welcome to Woo!" );
        include( "woo/view/main.php" );
    }
}

?>   
