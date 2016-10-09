<?php
	
$title = "Update chapters of books";

require_once("gb/controller/BookController.php");
require_once("gb/domain/Book.php");
require_once("gb/mapper/GenreMapper.php");
require_once("gb/mapper/ChapterMapper.php");

$bookController = new gb\controller\BookController();
$bookController->process();

$genreMapper = new gb\mapper\GenreMapper();
$allGenres = $genreMapper->findAll();

$chapterMapper = new gb\mapper\ChapterMapper();

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
    <li><a href="search_books.php">Search books</a></li>
	<li class="selecteditem"><a href="list_book_chapters.php">Update chapters</a></li>
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
Genre: <select style="width: 200px" name="genre">
<option value="">--------Book genres ---------- </option>
<?php
    foreach($allGenres as $genre) {
        echo "<option value=\"", $genre->getUri(), "\">", $genre->getName(), "</option>" ;
    }
                    
?>
        </select>
<input type ="submit" name="search_book" value="Search">
</form>
<br>

<?php
    $books = $bookController->getSearchResult();
    if (count($books) > 0) {
    print count($books) . " books found";
?>
<table id="nicetable">
    <tr>
        <th>Book name</th>
        <th>Chapters</th>
        <th>Add chapters</th>  
    </tr>
<br><br>
<?php
        foreach($books as $book) {
 ?>
    <tr>
	    <td><a href = "update_book_chapters.php?book_uri=<?php echo $book->getUri(); ?>"><?php echo $book->getName(); ?></td>
        <td><a href = "update_book_chapters.php?book_uri=<?php echo $book->getUri(); ?>"><?php echo $chapterMapper->getNumChapters($book); ?></td>
        <td><a href = "add_book_chapters.php?book_uri=<?php echo $book->getUri(); ?>">Add chapter</td>
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