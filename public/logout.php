<?php

$_SESSION = array();
if(session_destroy()){
  header("location: index.php");
}