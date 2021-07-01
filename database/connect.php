<?php
	$mysqli= new mysqli("localhost", "root", "", "bot") or die("Database Error");
	if(mysqli_connect_errno()){
		echo "Este sitio esta presentando problemas";
	}
	$mysqli->set_charset("utf8");
?>