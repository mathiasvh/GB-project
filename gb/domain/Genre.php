<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Genre extends DomainObject {    
      
    private $uri;
    private $name;
    private $description;
    

    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }
    
    function setUri( $uri ) {
        $this->uri = $uri;        
    }

    function getUri( ) {
        return $this->uri;
    }
    
    function setName ( $name ) {
        $this->name = $name;
    }
    
    function getName () {
        return $this->name;
    }
    
    function setDescription($description) {
        $this->description = $description;
    }
    
    function getDescription() {
        return $this->description;
    }

}

?>
