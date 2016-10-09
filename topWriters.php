<?php
	
$title = "Top Writers";
require_once("gb/mapper/GenreMapper.php");
require_once("gb/mapper/TopMapper.php");
require_once("gb/controller/TopController.php");

$genreMapper = new gb\mapper\GenreMapper();
$allGenres = $genreMapper->findAll();
$topMapper = new gb\mapper\TopMapper();
$topController = new gb\controller\TopController();



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
	<li><a href="list_book_chapters.php">Update chapters</a></li>
    <li><a href="list_spouses.php">Writer spouses</a></li>
    <li><a href="list_books_win_awards.php">Books & awards</a></li>
    <li class="selecteditem"><a href="toplists.php">Top lists</a></li>
</ul>
</div>
</div>
<div id="mainwrapper">
<div class="main">
<h2 class="contentTitle"><?php print $title;?></h2>




    
<form method="post">
Top <input type="number" style="width: 50px" name ="top_nb" min = 0 step = 5> writers by number of
          <input type="radio" name="by" value = 'awards' checked="checked"> awards 
          <input type="radio" name="by" value = 'books' > books 

in genre 
            <select style="width: 200px" name="genre">
                <option value="">--------Book genres ---------- </option>
                <?php
                foreach($allGenres as $genre) {
                    echo "<option value=\"", $genre->getUri(), "\">", $genre->getName(), "</option>";}
                ?>   
            </select>
        <input style="margin-left: 10px" type ="submit" name="search_writers" value="Search" ><br>
</form>
<br>
 
<?php
    $topController->process();
    $results = $topController->getSearchResult();
    print count($results) . " results found";
    if (count($results) > 0) {
?>
<br><br>
<table id="nicetable">
    <tr>
        <th>Writer</th>        
        <th>Number of <?php if ($_POST["by"]=='') print 'books'; else print $_POST["by"]; ?></th>
    </tr>    
<?php
        foreach($results as $res) {
 ?>
       <tr>
		    <td><?php echo $res->getName(); ?></td>
            <td><?php echo $res->getNb(); ?></td>
		
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