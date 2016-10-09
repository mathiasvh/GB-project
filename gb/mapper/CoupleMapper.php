<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Couple.php" );


class CoupleMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT a.*, b.* from writer a, is_spouse_of b where a.writer_uri = b.writer_uri and a.writer_uri = ?";
        $this->selectAllStmt = "SELECT a.*, b.* from writer a, is_spouse_of b where a.writer_uri = b.writer_uri"; 
    } 
    
    function getCollection( array $raw ) {
        
        $coupleCollection = array();
        foreach($raw as $row) {
            array_push($coupleCollection, $this->doCreateObject($row));
        }
        
        return $coupleCollection;
    }

    protected function doCreateObject( array $array ) {
        $obj = null;        
        if (count($array) > 0) {
            $id = $array['writer_uri'] . $array['person_uri'] . $array['from_time'] . $array['to_time'];
            $obj = new \gb\domain\Couple($id);
            
            $obj->setWriter($array['writer_uri']);
            $obj->setPerson($array['person_uri']);
            $obj->setDate($array['from_time'], $array['to_time']);
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
    
    // Returns writers married to writers
    function getWritersSpouses(){
        $con = $this->getConnectionManager();
        $selectStmt = ' 
            SELECT DISTINCT b.* 
                FROM writer a
                JOIN is_spouse_of b 
                ON a.writer_uri = b.person_uri
            ';
        $arr = array();
        $couples = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($couples);
    }
    

}


?>
