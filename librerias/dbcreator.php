<?php 

function creadorDB($HOST,$USER,$PASS){
	// Create connection
$conn = mysqli_connect($HOST, $USER, $PASS);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql1 = "CREATE DATABASE IF NOT EXISTS financiera";
if (mysqli_query($conn, $sql1)) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn)."<br>";
}

// Create connection
$conn1 = new mysqli($HOST, $USER, $PASS, "financiera");
// Check connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error)."<br>";
} 

// sql to create table
$sql = "CREATE TABLE `financiera`.`usuarios` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NULL,
  `user_pass` VARCHAR(100) NULL,
  `user_type` VARCHAR(45) NULL,
  `user_email` VARCHAR(100) NULL,
  PRIMARY KEY (`user_id`))";

if (mysqli_query($conn1, $sql)) {
    echo "Table usuarios created successfully <br>";
} else {
    echo "Error creating table: " . mysqli_error($conn1)."<br>";
}

}


creadorDB("localhost","root","123");
 ?>