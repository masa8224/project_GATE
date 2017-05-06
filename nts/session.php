<?php 
	if (!isset($_SESSION['Auser'])) {
        header("Location: index.php");
		exit(0);
    }
    
	
	?>