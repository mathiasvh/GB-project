<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Genre.php" );
require_once( "gb/domain/Book.php" );

class BookMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT * FROM book where uri = ?";
        $this->selectAllStmt = "SELECT * FROM book order by name";        
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
            $obj = new \gb\domain\Book( $array['uri'] );

            $obj->setUri($array['uri']);
            $obj->setName($array["name"]);
            $obj->setDescription($array['description']);
            $obj->setPublicDate($array['first_publication_date']);  
            $obj->setLanguage($array['original_language']); 
        } 
        
        return $obj;
    }

    protected function doInsert( \gb\domain\DomainObject $object ) {
        /*$values = array( $object->getName() ); 
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );*/
    }
    
    function update( \gb\domain\DomainObject $object ) {
        //$values = array( $object->getName(), $object->getId(), $object->getId() ); 
        //$this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    function selectAllStmt() {
        return $this->selectAllStmt;
    }
    
    // Returns a collection of books
    function getBooks($genre, $name) {
        $con = $this->getConnectionManager();
        $selectStmt = '
            SELECT b.*
            FROM book b, has_genre g
            WHERE g.genre_uri LIKE ?
               AND b.uri = g.book_uri
               AND b.name LIKE ?
            GROUP BY b.name';
        $arr = array('%'.$genre.'%', '%'.$name.'%');
        $books = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($books);
    }
    
}


?>
