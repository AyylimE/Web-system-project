<?php
    //ideweb connection
	$server = 'localhost:3306';
	$username = 'viclim16';
	$password = 'ccBudSSoAB';
	$database = 'viclim16_db';
	
	try{
		$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
	} catch(PDOException $e){
		die( "Connection to database failed!: " . $e->getMessage());
	}