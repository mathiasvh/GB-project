<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Writer.php" );

class WriterMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT a.*, b.* FROM person a, writer b 
                             WHERE a.uri = b.writer_uri AND a.uri = ?";
        $this->selectAllStmt = "SELECT a.*, b.* FROM person a, writer b 
                                WHERE a.uri = b.writer_uri"; 
    } 
    
    function getCollection( array $raw ) {
        
        $writerCollection = array();
        foreach($raw as $row) {
            array_push($writerCollection, $this->doCreateObject($row));
        }
        
        return $writerCollection;
    }

    protected function doCreateObject( array $array ) {
        $obj = null;        
        if (count($array) > 0) {
            $obj = new \gb\domain\Writer( $array['uri'] );

            $obj->setUri($array['uri']);
            $obj->setFullName($array['full_name']);
            $obj->setDescription($array['description']);
            $obj->setDateOfBirth($array['birth_date']);
            $obj->setDateofDeath($array['death_date']);
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
    
    // Returns a collection of writers according to the specified name, date of birth or country
    function getWriters ($name, $dob, $country) {
        $con = $this->getConnectionManager();
        $arr = array();
        if (strlen($country) == 0) {
            $arr = array('%'.$name.'%', '%'.$dob.'%');
            $selectStmt = ' 
            SELECT a.*, b.* 
            FROM person a, writer b 
            WHERE a.uri = b.writer_uri 
                AND a.full_name LIKE ?
                AND a.birth_date LIKE ?
            GROUP BY a.full_name';
        } else {
            $selectStmt = ' 
            SELECT a.*, b.* 
            FROM person a, writer b, has_citizenship c 
            WHERE a.uri = b.writer_uri 
                AND a.uri = c.person_uri
                AND a.full_name LIKE ?
                AND a.birth_date LIKE ?
                AND c.country_iso_code LIKE ?
            GROUP BY a.full_name';
            $arr = array('%'.$name.'%', '%'.$dob.'%', $country);
        }
        $writers = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($writers);
    }
    
}
?>
