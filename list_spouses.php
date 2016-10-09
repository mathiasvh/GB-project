<?php
	
$title = "Writers whose spouses are writers";

require_once("gb/mapper/WriterMapper.php");
require_once("gb/mapper/CoupleMapper.php");
$coupleMapper = new gb\mapper\CoupleMapper();
$allCouples = $coupleMapper->getWritersSpouses();
$writerMapper = new gb\mapper\WriterMapper();

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
    <li class="selecteditem"><a href="list_spouses.php">Writer spouses</a></li>
    <li><a href="list_books_win_awards.php">Books & awards</a></li>
    <li><a href="toplists.php">Top lists</a></li>
</ul>
</div>
</div>
<div id="mainwrapper">
<div class="main">
<h2 class="contentTitle"><?php print $title;?></h2>





<form method="post">
<table id="nicetable">

<tr>
        <th>Writer</th>
        <th>Spouse</th>
        <th>From time</th>  
        <th>To time </th>
    </tr>  
<?php
        foreach($allCouples as $couple) {
 ?>
       <tr>
	    <td><?php echo $writerMapper->find($couple->getWriter())->getFullName(); ?></td>
            <td><?php echo $writerMapper->find($couple->getPerson())->getFullName(); ?></td>
            <td><?php echo $couple->getFromDate(); ?></td>
            <td><?php echo $couple->getToDate(); ?></td>
	</tr>     
<?php        
        }
?>
</table>
</form>

<?php
	require("template/bottom.tpl.php");
?>