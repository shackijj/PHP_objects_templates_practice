<?php

$classname = "Task";

$path = "tasks/{$classname}.php";
if ( ! file_exists($path) ) {
    throw new Exception("File {$path} does not exist.\n");
}

require_once( $path );

//print_r( get_declared_classes() );

$qclassname = "tasks\\$classname";

if( ! class_exists($qclassname) ) {
    throw new Exception("Class {$qclassname} not found.\n");
}

$myObj = new $qclassname();
$myObj->doSpeak();

print "My object has class " . get_class($myObj) . "\n";
print "Is myObj instance of task\TaskParent? Answer: " . ($myObj instanceof tasks\TaskParent ? "Y" : "N" ) . "\n";
print "Let's see tasks\Task::class - " . tasks\Task::class . "\n";

?>
