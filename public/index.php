<?php

require_once __DIR__.'/../vendor/autoload.php';
include(__DIR__.'/../includes/session.php');

$DB = votechDB::getConnection();
// echo phpinfo();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once __DIR__.'/../includes/partials/_head.php';?>
  <title>Votech</title>
</head>
<body>
  <?php
    include_once __DIR__.'/../includes/partials/_NavBar.php';
  ?>
  <section id="main" class="container ">
      <div class="row">
        <div class="col s12">
          <div class="card card-center">
            <div class="card-content">
                <span class="card-title center-align">Results</span>
                <!-- <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iste alias nisi odio minus dolor debitis veniam ab sapiente sed, soluta magni.</p> -->
                <div class="result-table  mt-6">
                  <table class="striped ">
                    <thead> 
                      <tr>
                          <th>Party Name</th>
                          <th>Total Number of candidate</th>
                          <th>Total Wins</th>
                      </tr>
                    </thead>
            
                    <tbody>
                      <tr>
                        <td>Alvin</td>
                        <td>50</td>
                        <td>23</td>
                      </tr>
                      <tr>
                        <td>Alan</td>
                        <td>50</td>
                        <td>20</td>
                      </tr>
                      <tr>
                        <td>Jonathan</td>
                        <td>10</td>
                        <td>7</td>
                      </tr>
                    </tbody>
                  </table>

                </div>
            </div>
            
          </div>
        </div>
      </div>
  </section>
  
  <!-- CDN -->  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.sidenav');
      var instances = M.Sidenav.init(elems);
  });
  </script>
</body>
</html>