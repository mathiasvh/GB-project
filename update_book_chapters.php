<?php
	
require_once("gb/controller/BookController.php");
require_once("gb/mapper/ChapterMapper.php");
require_once("gb/domain/Book.php");

$bookController = new gb\controller\BookController();
$bookController->process();
$book_uri = $bookController->getSelectedBookUri();

$chapterMapper = new gb\mapper\ChapterMapper();
$allChapters = $chapterMapper->getBookChapters($book_uri);
$highestChapterNb = 0;


//=========== Replace by book name and chapter number? =======
$title = "book uri = " . $book_uri;

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
	<li  class="selecteditem"><a href="list_book_chapters.php">Update chapters</a></li>
    <li><a href="list_spouses.php">Writer spouses</a></li>
    <li><a href="list_books_win_awards.php">Books & awards</a></li>
    <li><a href="toplists.php">Top lists</a></li>
</ul>
</div>
</div>
<div id="mainwrapper">
<div class="main">
<h2 class="contentTitle"><?php print $title;?></h2>






<script type="text/javascript">
    function updateNow(chapterNb) {
        var highestChapterNb = document.getElementById("id_highestChapterNb").value;
        var currId = "id_old_text" + chapterNb;
        var tempId;
        for (var i = 0; i <= highestChapterNb; i++) { 
            tempId = "id_old_text" + i;
            try {
            document.getElementById(tempId).style.display="none";
            } catch(err) {
                
            }
        }
        document.getElementById(currId).style.display="inline";
    }
</script>

<form method="post">
Chapter: &nbsp; &nbsp; <select style="width: 200px" name="chapter" id="chapter_combo" onchange="updateNow(this.value);"/>
        <option value="0">--------Chapter ---------- </option>
                    <?php
                    foreach($allChapters as $chapter) {
                        if ($chapter->getNumber() > $highestChapterNb) {
                            $highestChapterNb = $chapter->getNumber();
                        }
                        echo "<option value=\"", $chapter->getNumber(), "\">", $chapter->getNumber(), "</option>";
                    
                    }
                    echo "</select>";
                    echo "<textarea style='display: none;' id='id_highestChapterNb'>",$highestChapterNb,"</textarea>";
                    ?>
<br><br>
Old text: <br><textarea name="old_text0" id="id_old_text0" cols="60" rows="6" placeholder="No text to display." readonly/></textarea>
                <?php
                    foreach($allChapters as $chapter) {
                        echo "<textarea name='old_text", $chapter->getNumber(),"' id='id_old_text", $chapter->getNumber(), "' 
                              cols='60' rows='6' readonly style='display: none;'>", $chapter->getText(), "</textarea>";
                    }
                    ?>
<br><br>
New text: <br><textarea name="new_text" cols="60" rows="6" placeholder="Write a new chapter text."></textarea>
<br><br><input type ="submit" name="update" value="Update" >
</form>
<?php
	require("template/bottom.tpl.php");
?>