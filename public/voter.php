<?php
 require_once __DIR__.'/../vendor/autoload.php';
 require_once __DIR__.'/../includes/session.php';

 $db = votechDB::getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once __DIR__.'/../includes/partials/_head.php'; ?>
  <title>Voter</title>
</head>
<body>
  <?php include_once __DIR__.'/../includes/partials/_NavBar.php'; ?>
  <div class="container center text-centet" style="margin-top: 20rem;">
    <a href="#vote" class="btn waves-effect waves-dark grey darken-4 btn modal-trigger" style="width: 7rem; height: 3rem; padding-top:0.3rem">Vote</a>
  </div>
  <!-- Modal Structure -->
  <div id="vote" class="modal">
  <form action="/voter.php" method="POST">
    <div class="modal-content">
      <h4>Vote for your candidate</h4>
      <table class="stripped">
        <thead>
          <td>Party Name</td>
          <td>Candidate Name</td>
          <td>Action</td>
        </thead>
        <tbody>
          <?php
          
            if(isset($_SESSION['_id'])){
              $voterId = $_SESSION['_id'];
              $sql = 'select c.id,c.name,c.area_id, c.party_id, party.name as partyName from ((candidate c inner join party on c.party_id = party.id) inner join voter 
              on c.area_id = voter.area_id AND voter.id = '.$voterId.');';
              $result =  $conn->query($sql);
              ?>
              
           
              <?php
              while($obj = $result->fetch_object()){
                echo '
                  <tr>
                    <td>'.$obj->partyName.'</td>
                    <td>'.$obj->name.'</td>
                    <td><label>
                    <input class="with-gap" name="vote" type="radio" value="'.$obj->id.'" />
                    <span>Vote</span>
                  </label></td>
                  </tr>';
              }
              ?>
              <tr>  
                <td>BJP</td>
                <td>Sommana</td>
                <td>

                </td>
              </tr>

              <?php
            } else {
              echo 'session is not set';
            }
          ?>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button type="submit" name="vote" class="modal-close waves-effect waves-green btn-flat">Agree</button>
    </div>
  </form>
  </div>
  <?php 

  ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.sidenav');
      var instances = M.Sidenav.init(elems);

      var elems = document.querySelectorAll('.modal');
      var instances = M.Modal.init(elems);
  });
  </script>
</body>
</html>