<?php

require_once __DIR__.'/../vendor/autoload.php';

$conn = votechDB::getConnection();
  
session_start();
$_id = $_SESSION['_id'];
$table = $_SESSION['role'];

$result = $conn->select($table, array('id', 'name'), array('id'=>$_id));

if($result->num_rows == 0){

  header("location: login.php");
}

