<?php
namespace gb\domain;

require_once( "gb/domain/Person.php" );

class Writer extends Person {    
      
    private $date;
   
    function __construct( $id=null, $from = null, $to = null ) {
        parent::__construct( $id );
        $this->date[0] = $from;
        $this->date[1] = $to;
    }

    function setActiveTime ($from=null, $to=null) {
        if ($from != null) $this->date[0] = $from;
        if ($to != null) $this->date[1] = $to;
    }
    
    function getActiveTime () {
        return $this->date;
    }
    
    

}

?>
