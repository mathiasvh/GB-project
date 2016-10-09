<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class WinsAward extends DomainObject {    
    
    private $country;
    private $genre;
    private $books;
    

    function __construct( $country, $genre, $books ) {
        $this->country = $country;
        $this->genre = $genre;
        $this->books = $books;
        parent::__construct( $country.$genre );
    }
    

    function getCountry( ) {
        return $this->country;
    }
    
    function getGenre () {
        return $this->genre;
    }
    
    function getBooks() {
        return $this->books;
    }

}

?>
