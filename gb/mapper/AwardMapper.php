<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Award.php" );


class AwardMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT * FROM award where uri = ?";
        $this->selectAllStmt = "SELECT * FROM award order by name";        
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
            $obj = new \gb\domain\Award( $array['uri'] );

            $obj->setUri($array['uri']);
            $obj->setName($array["name"]);
            $obj->setDescription($array['description']);            
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
    
    // Returns the number of awards won by the specified book
    function getNumAwards($book) {
        $con = $this->getConnectionManager();
        $selectStmt = ' 
            SELECT a.name
            FROM award a, wins_award w
            WHERE w.book_uri LIKE ?
                AND a.uri = w.award_uri 
            ';
        $num = $con->executeSelectStatement($selectStmt, array($book->getUri()));
        return sizeof($num);
    }
    
}


?>
