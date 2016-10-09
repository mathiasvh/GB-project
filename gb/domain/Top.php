<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );


class Top extends DomainObject {    
    
    private $id;
    private $name;
    private $number;
    
    function __construct( $id = null ) {
        parent::__construct( $id );
    }
    
    function setName($name) {
        $this->name = $name;
    }
    
    function getName(  ) {
        return $this->name;
    }
    
    function setNb($number) {
        $this->number = $number;
    }
    
    function getNb(  ) {
        return $this->number;
    }
    
    function setId($id) {
        $this->id = $id;
    }
    
    function getId() {
        return$this->id;
    }

}

?>
