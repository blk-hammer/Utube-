<?php

//  good for finding errors   mysqli_report(MYSQLI_REPORT_ALL);
session_start();
$servername='localhost';
$username='rishabh';
$password='Rishabh.1999';
$dbname='videotube';

$conn= mysqli_connect($servername,$username,$password);
$conn1= mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
    die("connection failed: ".mysqli_connect_error());
}

$sql="CREATE DATABASE IF NOT EXISTS videotube";
if(@mysqli_query($conn,$sql)){
    $sql1 = "CREATE TABLE IF NOT EXISTS categories (
        id INT PRIMARY KEY AUTO_INCREMENT ,
        name VARCHAR(50) NOT NULL)";
    if(@mysqli_query($conn1,$sql1)){
    }
    else
        echo " categories table creation failed";
    
    $q1="CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        fname VARCHAR(25),
        lname VARCHAR(25),
        username VARCHAR(25),
        email VARCHAR(100),
        password VARCHAR(255),
        signUpDate DATETIME DEFAULT CURRENT_TIMESTAMP,
        profilePic VARCHAR(255))";
    if(mysqli_query($conn1,$q1)){
    }
    $q1="CREATE TABLE IF NOT EXISTS likes (
        id INT PRIMARY KEY AUTO_INCREMENT ,
        username VARCHAR(50),
        videoId INT,
        commentId INT
        )";
    mysqli_query($conn1,$q1);
    $q1="CREATE TABLE IF NOT EXISTS dislikes (
        id INT PRIMARY KEY AUTO_INCREMENT ,
        username VARCHAR(50),
        videoId INT,
        commentId INT
        )";
    mysqli_query($conn1,$q1);
}
else
    echo "error";

?>