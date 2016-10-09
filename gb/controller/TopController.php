<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/TopMapper.php" );

class TopController extends PageController {
    private $result;
    
    function process() {
        if (isset($_POST["search_writers"])) {
            $this->result = $this->getTopWriters($_POST["top_nb"], $_POST["by"], $_POST["genre"]);
        }
        if (isset($_POST["search_books"])) {
            $this->result = $this->getTopBooks($_POST["top_nb"], $_POST["genre"]);
        }
        if (isset($_POST["search_genres"])) {
            $this->result = $this->getTopGenres($_POST["top_nb"], $_POST["by"]);
        }
        
    }
    
    function getTopWriters($nb, $by, $gen) {
        $mapper = new \gb\mapper\TopMapper();
        return $mapper->getTopWriters($nb, $by, $gen);
    }
    
    function getTopBooks($nb, $gen) {
        $mapper = new \gb\mapper\TopMapper();
        return $mapper->getTopBooks($nb, $gen);
    }
    
    function getTopGenres($nb, $by) {
        $mapper = new \gb\mapper\TopMapper();
        return $mapper->getTopGenres($nb, $by);
    }
    
    function getSearchResult() {
        return $this->result;
    }
}

?>