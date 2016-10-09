<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

// a class of books
// every book has its attributes: uri, name, public_date, language and description
class Book extends DomainObject {    
      
    private $uri;
    private $name;
    private $public_date;
    private $language;
    private $description;
    private $highestChapterNb;
   
    function __construct( $id=null ) {
        parent::__construct( $id );
    }
    
    function setUri($uri) {
        $this->uri = $uri;
    }
    function getUri() {
        return $this->uri;
    }
       
    function setName ( $full_name ) {
        $this->name = $full_name;        
    }
    
    function getName () {
        return $this->name;
    }
    
    function setDescription( $description) {
        $this->description = $description;
    }
    
    function getDescription () {
        return $this->description;
    }
    
    function setPublicDate ($date) {
        if ($date == '0000-00-00') $date = '';
        $this->public_date = $date;
    }
    
    function getPublicDate() {
        return $this->public_date;
    }
    
    function setLanguage( $lang) {
        $this->language = $lang;
    }
    
    function getLanguage() {
        return $this->language;
    }
    
    function getHighestChapterNb() {
        return $this->highestChapterNb;
    }
    
    function setHighestChapterNb($nb) {
        $this->highestChapterNb = $nb;
    }

}

?>
