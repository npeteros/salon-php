<?php
    include 'src/includes/header.php';

	$_SESSION = []; 
	session_destroy();
    header("Location: index.php");
	
    include 'src/includes/footer.html';
?>