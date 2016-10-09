<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

// a class of chapters
// every chapter has its attributes: id, uri, number and text
class Chapter extends DomainObject {
    private $id;
    private $uri;
    private $number;
    private $text;
    

    function __construct($id) {
        parent::__construct( $id);
    }
    
    function setUri( $uri ) {
        $this->uri = $uri;        
    }

    function getUri() {
        return $this->uri;
    }
    
    function setNumber ( $number ) {
        $this->number = $number;
    }
    
    function getNumber() {
        return $this->number;
    }
    
    function setText($text) {
        $this->text = $text;
    }
    
    function getText() {
        return $this->text;
    }
    
    function setId($id) {
        $this->id = $id;
    }
    
    function getId() {
        return$this->id;
    }

}

?>
