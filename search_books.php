<?php
	
$title = "Search books";

require_once("gb/controller/BookController.php");
require_once("gb/domain/Book.php");
require_once("gb/mapper/GenreMapper.php");
require_once("gb/mapper/AwardMapper.php");

$bookController = new gb\controller\BookController();
$bookController->process();

$genreMapper = new gb\mapper\GenreMapper();
$allGenres = $genreMapper->findAll();
 
$awardMapper = new gb\mapper\AwardMapper();
 
// Onderstaande lijnen zijn instructies voor de web-browser over hoe ze een pagina moet
// implementeren.
session_start(); 		// -- session_start() op deze plek is niet erg netjes, maar voldoet voor dit practicum
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl-BE" lang="nl-BE">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php // s ?>
	<title><?php print $title;?></title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<!--<h2 class="indexTitle">Index</h2>-->
<div id="menuwrapper">
<div id="cssmenu">
<ul>
	<li><a href="index.php">Home</a></li>
    <li><a href="search_writers.php">Search writers</a></li>
    <li class="selecteditem"><a href="search_books.php">Search books</a></li>
	<li><a href="list_book_chapters.php">Update chapters</a></li>
    <li><a href="list_spouses.php">Writer spouses</a></li>
    <li><a href="list_books_win_awards.php">Books & awards</a></li>
    <li><a href="toplists.php">Top lists</a></li>
</ul>
</div>
</div>
<div id="mainwrapper">
<div class="main">
<h2 class="contentTitle"><?php print $title;?></h2>




   
<form method="post">
Book name: <input type="text" name ="book_name"><br>
Genre: <select style="width: 300px" name="genre">
        <option value="">--------Book genres ---------- </option>
        <?php
         foreach($allGenres as $genre) {
          echo "<option value=\"", $genre->getUri(), "\">", $genre->getName(), "</option>" ;
         }
                    
        ?>   
        </select>
        <br>
        <input style="margin-left: 10px" type ="submit" name="search_book" value="Search">
</form>
<br>
<?php
    $books = $bookController->getSearchResult();
    print count($books) . " books found";
    if (count($books) > 0) {
?>
<table id="nicetable">
    <tr>
        <th>Book name</th>        
        <th>Awards</th>
        <th>Published</th>
        <th>Description</th>
    </tr>    
<?php
        foreach($books as $book) {
 ?>
       <tr>
		    <td><?php echo $book->getName(); ?></td>
            <td><?php echo $awardMapper->getNumAwards($book); ?></td>
            <td><?php echo $book->getPublicDate(); ?></td>
            <td><?php echo $book->getDescription(); ?></td>
		
	</tr>     
<?php        
        }
?>
</table>   
<?php
    }
?>

<?php
	require("template/bottom.tpl.php");
?>