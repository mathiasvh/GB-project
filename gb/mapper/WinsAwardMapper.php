<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/WinsAward.php" );


class WinsAwardMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT c.name AS cn, g.name AS gn, COUNT(b.uri) AS bc FROM country c, genre g, book b WHERE c.uri =?";
        $this->selectAllStmt = "SELECT c.name AS cn, g.name AS gn, COUNT(b.uri) AS bc FROM country c, genre g, book b";        
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
            $obj = new \gb\domain\WinsAward($array['cn'], $array['gn'], $array['bc']);
            
        } 
        
        return $obj;
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    function selectAllStmt() {
        return $this->selectAllStmt;
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
    
    // Question 5
    function getList ($from = null, $to = null) {
        $con = $this->getConnectionManager();
        $selectStmt = ' 
            SELECT c.name AS cn, g.name AS gn, COUNT(b.uri) AS bc 
            FROM country c, genre g, book b, wins_award wa, award a, writes wr, has_citizenship hc
            WHERE wr.book_uri = b.uri
            	AND wr.writer_uri = hc.person_uri
            	AND c.iso_code = hc.country_iso_code
            	AND a.uri = wa.award_uri
            	AND g.uri = wa.genre_uri
            	AND b.uri = wa.book_uri
            	AND b.first_publication_date >= ?
            	AND b.first_publication_date < ?
            GROUP BY c.name, g.name';
        $arr = array('0000-00-00', '9999-99-99');
        if ($from != '') $arr[0] = ($from.'% ');
        if ($to != '') $arr[1] = ($to.'% ');

        $list = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($list);
    }
    
}


?>
