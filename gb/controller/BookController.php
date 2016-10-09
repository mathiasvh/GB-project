<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/BookMapper.php" );
require_once("gb/mapper/ChapterMapper.php" );

class BookController extends PageController {
    private $books;
    private $selectedBookUri;
    
    function process() {
        if (isset($_POST["search_book"])) {
            $this->books = $this->searchBook($_POST["genre"], $_POST["book_name"]);
        }
        
        if (isset($_POST["update"]) && $_POST["chapter"] != 0) {
            $this->updateBookChapter($_GET["book_uri"], $_POST["new_text"], $_POST["chapter"]);
        }
        
        if (isset($_POST["add_chapter"]) && $_POST["chapter_number"] != 0) {
            $this->addBookChapter($_GET["book_uri"], $_POST["new_text"], $_POST["chapter_number"]);
        }
        
        if (isset($_GET["book_uri"])) {
            $this->selectedBookUri = $_GET["book_uri"];
        }
    }
    
    function searchBook($genre, $name) {
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->getBooks($genre,$name);
        
    }
    
    function getSearchResult() {
        return $this->books;
    }

    function updateBookChapter($book_uri, $new_text, $chapter_number) {
       if (isset($_POST["new_text"])) {
            $mapper = new \gb\mapper\ChapterMapper();
            $stmt = "UPDATE chapter
                     SET text = ?
                     WHERE book_uri = ? AND chapter_number = ?";
            $con = $mapper->getConnectionManager();
            $result = $con->executeUpdateStatement($stmt, array($new_text, $book_uri, $chapter_number));
        }
        
    }
    function addBookChapter($book_uri, $new_text, $chapter_number) {
        if (isset($_POST["new_text"]) && isset($_POST["chapter_number"])) {
            $mapper = new \gb\mapper\ChapterMapper();
            $insertStmt = "INSERT INTO chapter
                          VALUES (?,?,?)";
            $con = $mapper->getConnectionManager();
            $result = $con->executeUpdateStatement($insertStmt, array($book_uri, $chapter_number, $new_text));
        }
    }
    
    function getSelectedBookUri() {
        return $this->selectedBookUri;
    }

}

?>