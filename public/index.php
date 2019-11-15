<?php

require_once __DIR__.'/../vendor/autoload.php';
$conn = votechDB::getConnection();
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
                          <th>Candidate Name</th>
                          <th>Area Name</th>
                          <th>Total Voters</th>
                          <th>No of Votes</th>
                      </tr>
                    </thead>
            
                    <tbody>
                      <?php
                        $sql = 'select party.name as partyName, candidate.name as candName, area.name as areaName, area.total_voters, result.no_of_votes from result INNER JOIN candidate ON result.cand_id=candidate.id INNER JOIN party ON party.id = candidate.party_id INNER JOIN area ON result.area_id = area.id; ';
                        $result = $conn->query($sql);

                        while($obj = $result->fetch_object())
                        {
                          $html = '
                            <tr>
                              <td>'.$obj->partyName.'</td>
                              <td>'.$obj->candName.'</td>
                              <td>'.$obj->areaName.'</td>
                              <td>'.$obj->total_voters.'</td>
                              <td>'.$obj->no_of_votes.'</td>
                            </tr>
                          ';

                          echo $html;
                        }

                      ?>
                      <!-- <tr>
                        <td>Jonathan</td>
                        <td>10</td>
                        <td>7</td>
                      </tr> -->
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