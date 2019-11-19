<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';

$conn = votechDB::getConnection();
  

$_id = $_SESSION['_id'];
$table = $_SESSION['role'];

$result = $conn->select($table, array('id', 'name'), array('id'=>$_id));
// echo $result->num_rows;
if($result->num_rows == 0){

  header("location: login.php");
} else {
  
  if($role == 'admin'){
    $_SESSION['admin'] = true;
  } else {
    $_SESSION['admin'] = false;
  }

} 

