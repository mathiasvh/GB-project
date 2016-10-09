<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/WinsAwardMapper.php" );

class WinAwardController extends PageController {
    private $result;
    
    function process() {
        if (isset($_POST["search"])) {
            $this->result = $this->searchBooksWinAwards($_POST["from_time"], $_POST["to_time"]);
        }
    }
    
    function searchBooksWinAwards($from, $to) {
        $mapper = new \gb\mapper\WinsAwardMapper();
        return $mapper->getList($from,$to);
    }
    
    function getSearchResult() {
        return $this->result;
    }
}

?>