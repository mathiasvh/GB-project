<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Top.php" );


class TopMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT g.name AS Name, COUNT(hg.book_uri) AS Number
            FROM genre g, has_genre hg
            WHERE g.uri = hg.genre_uri
            GROUP BY g.name
            ORDER BY  number_of_books DESC 
            LIMIT 1";
        $this->selectAllStmt = "SELECT g.name AS Name, COUNT( hg.book_uri ) AS Number
            FROM genre g, has_genre hg
            WHERE g.uri = hg.genre_uri
            GROUP BY g.name
            ORDER BY  number_of_books DESC "; 
    } 
    
    function getCollection( array $raw ) {
        
        $cl = array();
        foreach($raw as $row) {
            array_push($cl, $this->doCreateObject($row));
        }
        
        return $cl;
    }

    protected function doCreateObject( array $array ) {
        $obj = null;        
        if (count($array) > 0) {
            $id = $array['Name'] . $array['Number'] ;
            $obj = new \gb\domain\Top($id);
            
            $obj->setName($array['Name']);
            $obj->setNb($array['Number']);
        } 
        
        return $obj;
    }

    protected function doInsert( \gb\domain\DomainObject $object ) {
    }
    
    function update( \gb\domain\DomainObject $object ) {
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    function selectAllStmt() {
        return $this->selectAllStmt;
    }
    
    function getTopWriters ($number, $by, $genre) {
        if (strlen($number) < 1) $number = 9999;
        else $number = intval($number);
        if (strlen($genre) < 1) $genre = '%';
        $con = $this->getConnectionManager();
        $arr = array($genre);
        if ($by == 'awards'){
            $selectStmt = ' 
                SELECT p.full_name AS Name, COUNT( wa.book_uri ) AS Number
                FROM person p, wins_award wa, writes ws
                WHERE ws.writer_uri = p.uri
                    AND wa.book_uri = ws.book_uri
                    AND wa.genre_uri LIKE ?
                GROUP BY Name
                ORDER BY Number DESC 
                LIMIT '.$number.'';
        }
        else {
            $selectStmt = ' 
                SELECT p.full_name AS Name, COUNT( ws.book_uri ) AS Number
                FROM person p, writes ws
                WHERE ws.writer_uri = p.uri
                	AND ws.book_uri IN (
                    	SELECT book_uri
                        FROM has_genre
                        WHERE genre_uri LIKE ?
                    )
                GROUP BY Name
                ORDER BY Number DESC 
                LIMIT '.$number.'';
        }
        $res = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($res);
    }
    
    function getTopBooks ($number, $genre) {
        if (strlen($number) < 1) $number = 9999;
        else $number = intval($number);
        if (strlen($genre) < 1) $genre = '%';
        $con = $this->getConnectionManager();
        $arr = array($genre);
            $selectStmt = ' 
                SELECT b.name AS Name, COUNT( wa.book_uri ) AS Number
                FROM book b, wins_award wa
                WHERE wa.book_uri = b.uri
                    AND wa.genre_uri LIKE ?
                GROUP BY Name
                ORDER BY  Number DESC 
                LIMIT '.$number.'';
        $res = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($res);
    }
    
    function getTopGenres ($number, $by) {
        if (strlen($number) < 1) $number = 9999;
        else $number = intval($number);
        $con = $this->getConnectionManager();
        $arr = array();
        if ($by == 'awards'){
            $selectStmt = ' 
                SELECT g.name AS Name, COUNT( wa.genre_uri ) AS Number
                FROM genre g, wins_award wa
                WHERE wa.genre_uri = g.uri
                GROUP BY Name
                ORDER BY Number DESC 
                LIMIT '.$number.'';
        }
        else {
            $selectStmt = ' 
                SELECT g.name AS Name, COUNT( hg.book_uri ) AS Number
                FROM genre g, has_genre hg
                WHERE g.uri = hg.genre_uri
                GROUP BY Name
                ORDER BY Number DESC 
                LIMIT '.$number.'';
        }
        $res = $con->executeSelectStatement($selectStmt, $arr);
        return $this->getCollection($res);
    }

}


?>
