<?php
	
$title = "Search writers";

require_once("gb/controller/SearchWritersController.php");
require_once("gb/domain/Writer.php");
require_once("gb/mapper/CountryMapper.php");

$searchWriterController = new gb\controller\SearchWritersController();
$searchWriterController->process();

$countryMapper = new gb\mapper\CountryMapper();
$allCountries = $countryMapper->findAll();


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
    <li class="selecteditem"><a href="search_writers.php">Search writers</a></li>
    <li><a href="search_books.php">Search books</a></li>
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
<table style="width: 100%">

Writer name: <input type="text" name ="full_name"><br>
Date of birth: <input type="text" name ="date_of_birth" ><br>         
Country: 
    <select style="width: 200px" name="country">
      <option value="">--------Select country ---------- </option>
       <?php
       foreach($allCountries as $country) {
         echo "<option value=\"", $country->getIsoCode(), "\">", $country->getCountryName(), "</option>" ;
        }
        ?>      
    </select><br>
<input style="margin-left: 10px" type ="submit" name="search_writer" value="Search" >
</form>
<br><br>

<?php
    $writers = $searchWriterController->getSearchResult();
    print count($writers) . " writers found";
    if (count($writers) > 0) {
?>
<table id="nicetable">
    <tr>
        <th>Full name</th>
        <th>Birth date</th>
        <th>Death date</th>
        <th>Description</th>
    </tr>    
<?php
        foreach($writers as $writer) {
 ?>
       <tr>
		<td><?php echo $writer->getFullName(); ?></td>
                <td><?php echo $writer->getDateOfBirth(); ?></td>
                <td><?php echo $writer->getDateOfDeath(); ?></td>
                <td><?php echo $writer->getDescription(); ?></td>
		
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