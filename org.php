<?php
include 'src/main.php';
// echo "City: " . $_GET['city'];
// echo "<br>";
// echo "Metro: " . $_GET['metro'];
// echo "<br>";
// echo "Cat: " . $_GET['cat'];
// echo "<br>";
// echo "Text: " . $_GET['text'];
// echo "<br>";
generateContext($_GET['city'], $_GET['metro'], $_GET['cat'], $_GET['text']);
