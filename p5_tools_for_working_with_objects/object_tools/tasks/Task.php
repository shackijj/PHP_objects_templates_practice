<?php

namespace tasks;

class TaskParent {}

class Task extends TaskParent {
    function doSpeak() {
        print "Hello\n";
    }
}
