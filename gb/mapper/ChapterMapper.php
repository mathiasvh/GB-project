<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Chapter.php" );


class ChapterMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT * FROM chapter WHERE book_uri = ? AND chapter_number = ?";
        $this->selectAllStmt = "SELECT * FROM chapter order by chapter_number";        
    } 
    
    function find($book, $chapter) {
        $id = $book.$chapter;
        $obj = new \gb\domain\Chapter($id);
        $obj->setUri($book);
        $obj->setNumber($chapter);
        $obj->setText('');
        echo $obj->getUri();
        return $object; 
    }
    
    function getCollection( array $raw ) {
        $customerCollection = array();
        foreach($raw as $row) {
            array_push($customerCollection, $this->doCreateObject($row));
        }
        return $customerCollection;
    }

    protected function doCreateObject( array $array ) {
        $obj = null;  
        if (count($array) > 0) {
            $id = $array['book_uri'].$array['chapter_number']; // weak entity -> book_uri+chapter_number = unique identifier
            $obj = new \gb\domain\Chapter($id);
            $obj->setUri($array['book_uri']);
            $obj->setNumber($array['chapter_number']);
            $obj->setText($array['text']);
        } 
        return $obj;
    }

    protected function doInsert( \gb\domain\DomainObject $object ) {
        /*
        $insertStmt = '
            INSERT INTO chapter (book_uri, chapter_number, text)
            VALUES (?,?,?)
        ';
        $values = array($object->getUri(), $object->getNumber(), $object->getText()); 
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
        */
    }
    
    function update( \gb\domain\DomainObject $object ) {
        /*
        if($object->getId() == null) echo ' NULL;';
        $updateStmt = '
            UPDATE chapter
            SET text = ?
            WHERE   book_uri = ?
                AND chapter_number = ?
        ';
        $values = array($object->getText(), $object->getUri(), $object->getNumber());
        $this->updateStmt->execute( $values );
        */
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    function selectAllStmt() {
        return $this->selectAllStmt;
    }
    
    // Returns number of chapters for the specified book
    function getNumChapters($book) {
        $con = $this->getConnectionManager();
        $selectStmt = ' 
            SELECT c.chapter_number 
            FROM chapter c
            WHERE c.book_uri LIKE ?';
        $arr = array($book->getUri());
        $num = $con->executeSelectStatement($selectStmt, $arr);
        return sizeof($num);
    }
    
    // Returns the collection of chapters of the specified book
    function getBookChapters($book_uri) {
        $con = $this->getConnectionManager();
        $selectStmt = ' 
            SELECT c.*
            FROM chapter c
            WHERE c.book_uri LIKE ?';
        $arr = array($book_uri);
        $customers = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($customers);
    }
    
}


?>
