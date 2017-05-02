<!DOCTYPE html> 
<html> 
<head> 
<title>Index</title> 
</head> 
    
<?php

//checks if you're logged in or not
    
session_start();
 
 if(!isset($_SESSION['user_id']) ){
	header("Location: login.php");
 }

?>
    
<body> 
    <h1>This is gonna be the index page</h1>
    
<?php if( isset($_SESSION['super_id']) ):?>
    <ul>
        <li><a href="register.php"> Register page</a></li>
        <li><a href="logout.php"> Logout</a></li>
    </ul>
<?php else: ?>
        <ul>
        <li><a href="logout.php"> Logout</a></li>
    </ul>   
<?php endif; ?>
    
</body>
</html>