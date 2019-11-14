<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/session.php';
// session_start();     
$conn = votechDB::getConnection();
$query = $conn->select('admin', '*', array('id' => $_SESSION['_id']));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once __DIR__ . '/../includes/partials/_head.php';
  ?>
  <title>Votech</title>
</head>

<body>
  <?php require_once __DIR__ . '/../includes/partials/_NavBar.php'; ?>

  <div class="container mt-6">
    <div class="insert ">
      <a href="#createVoter" class="btn modal-trigger waves-effect waves-light"> <i class="material-icons">person_add0</i> Create Voter</a>
      <a href="#createParty" class="btn modal-trigger waves-effect waves-light"> <i class="material-icons">group_add</i>Create Party</a>
    </div>
    <table class="striped">
      <thead>
        <tr>
          <th>Party Name</th>
          <th>Total Candidates</th>
          <th>Action </th>
        </tr>
      </thead>

      <tbody>
        <?php
        $result = $conn->select('party');

        if ($result->num_rows > 0) {

          while ($obj = $result->fetch_object()) {
            echo '<tr>
                  <td>' . $obj->name . '</td>
                  <td>' . $obj->total_candidates . '</td>
                  <td>
                    <a href="#update' . $obj->id . '" class="btn center left-align green accent-4 waves-effect waves-light modal-trigger mb"><i class="material-icons">edit</i>Edit</a>
                    <a href="#delete' . $obj->id . '" class="btn center mb red waves-effect modal-trigger waves-light"><i class="material-icons">delete</i> Delete </a>
                  </td>
                </tr>';
          }
        }
        $result->close();
        ?>
      </tbody>
    </table>

    <?php
    $result = $conn->select('party');

    // echo $result->num_rows ;
    if ($result->num_rows > 0) {
      while ($obj = $result->fetch_object()) {
        $update = '
        <div id="update' . $obj->id . '" class="modal">
          <form method="POST" action="/admin.php">
            <div class="modal-content">
            <h4>Edit the changes</h4>
            <table class="modal_table">
            <tbody>
              <input type="hidden" name="id" value="'.$obj->id.'"/>
              <tr class="modal_tr">
                <td>Name:</td>
                <td><input type="text" name="name" value="' . $obj->name . '"/></td>
              </tr>
              <tr class="modal_tr">
                <td>Total No of candidate:</td>
                <td><input type="number" disabled id="disabled" name="total_candidate" value="' . $obj->total_candidates . '"/></td>
              </tr>
            </tbody>

          </table>
          <div class="modal-footer">
          <button type="submit" name="update" class="btn  waves-effect waves-light green darken-3">Submit</button>
        </div>
          </form>
        </div>
          
        </div>';

        $delete = '
        <div id="delete' . $obj->id . '" class="modal">
          <div class="modal-content">
            <h4>Are You Sure</h4>
              <p>You really want to delete ?</p>
          </div>
          <div class="modal-footer">
            <a href="/admin.php?id='.$obj->id.'" type="sumbit" class="modal-close waves-effect red white-text waves-green btn-flat"> <i class="material-icons">delete_forever</i>Delete</a>
          </div> 
        </div>';

        echo $update . '<br/>' . $delete;
      }
    }

    $result->close();
    ?>
  </div>
  <div id="createVoter" class="modal">
    <div class="modal-content">
      <h4>Voter Details</h4>
      <form class="row s12" action="/admin.php" method="POST">
          <div class="input-field col s12">
            <input id="name" type="text" class="validate" name="name">
            <label for="name">Voter Name</label>
          </div>
          <div class="input-field col s12">
            <input id="pwd" type="password" class="validate" name="password">
            <label for="pwd">Password</label>
          </div>
          <div class="input-field col s12">
            <input id="age" type="text" class="validate" name="age">
            <label for="age">Voter Age</label>
          </div>
          <div class="input-field col s12">
            <input id="phoneno" type="text" class="validate" name="phoneNo">
            <label for="phoneno">Voter Phone No.</label>
          </div>
          <div class="input-field col s12">
            <input id="area_id" type="text" class="validate" name="area_id">
            <label for="area_id">Area Id</label>
          </div>
          <div class="col s12 center login-btn">
            <button type="submit" name="voter" class="btn btn-large waves-effect waves-light grey darken-3">Submit</button>
          </div>
        </form>
    </div>
  </div>
  <div id="createParty" class="modal">
    <div class="modal-content">
      <h4>Enter Party Details</h4>
      <form class="row s12" action="/admin.php" method="POST">
          <div class="input-field col s12">
            <input id="partyname" type="text" class="validate" name="partyName">
            <label for="partyname">Enter the Party Name</label>
          </div>
          <div class="input-field col s12">
            <input id="partypwd" type="password" class="validate" name="password">
            <label for="partypwd">Password</label>
          </div>
         
          <div class="col s12 center modal-footer login-btn">
            <button type="submit" name="party" class="btn btn-large waves-effect waves-light grey darken-3">Submit</button>
          </div>
        </form>
    </div>
  </div>
  <!-- CDN -->
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


<?php 
  if(isset($_POST['voter'])){
      $voterName = $_POST['name'];
      $votterPwd = $_POST['password'];
      $votterAge = $_POST['age'];
      $votterPhone = $_POST['phoneNo'];
      $votterAreaId = $_POST['area_id'];

      $values = array(
        'name' => $voterName,
        'password'=> $votterPwd,
        'age'=> $votterAge,
        'phone_no' => $votterPhone,
        'area_id' => $votterAreaId
      );

      $id = $conn->insert('voter',$values);
      print_r('\nvoter is created'.$id);
  }

  if(isset($_POST['party'])){
    $partyName = $_POST['partyName'];
    $partyPwd = $_POST['password'];
    $values = array(
      'name' => $partyName,
      'password' => $partyPwd
    );
    $id = $conn->insert('party',$values);

    print_r('\n    party is created '.$id);

  }

  if(isset($_POST['update'])){
    $values = array(
      'name' => $_POST['name']
    );
    $condition = array(
      'id' => $_POST['id']
    );

    $result = $conn->update('party', $values, $condition);
    print_r($result);
  }

  if(isset($_GET['id'])){
    $value = array(
      'id' => $_GET['id']
    );

    $result = $conn->delete('party', $value);

    if($result){
      // header("Refresh:0");
    } else {
      echo $result;
    }
  }
  
?> 
