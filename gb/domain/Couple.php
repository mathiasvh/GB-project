<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );
require_once ("gb/domain/Writer.php");


class Couple extends DomainObject {    
    
    private $id;
    private $writer;
    private $person;
    private $date;
    
    function __construct( $id = null ) {
        parent::__construct( $id );
    }
    
    function setWriter($writer) {
        $this->writer = $writer;
    }
    
    function getWriter(  ) {
        return $this->writer;
    }
    
    function setPerson($person) {
        $this->person = $person;
    }
    
    function getPerson(  ) {
        return $this->person;
    }
       
    function setDate($from = null, $to = null) {
        if ($from != null) $this->date[0] = $from;
        if ($to != null) $this->date[1] = $to;
    }
    
    function getFromDate() {
        return $this->date[0];
    }
    
    function getToDate() {
        return $this->date[1];
    }
    
    function setId($id) {
        $this->id = $id;
    }
    
    function getId() {
        return$this->id;
    }

}

?>
