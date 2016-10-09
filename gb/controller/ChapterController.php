<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/ChapterMapper.php");


class ChapterController extends PageController {
    function process() {
        if (isset($_POST["search"])) {
            print "Please provide some piece of code here to search books by genres!";
        }
        
    }
    
}

?>