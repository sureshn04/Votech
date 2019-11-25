<?php
session_start(); 
require_once __DIR__ . '/../vendor/autoload.php';
  
$conn = votechDB::getConnection();

if($_SESSION['role'] == 'party'){

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
      <a href="#createCandidate" class="btn modal-trigger waves-effect waves-light"> <i class="material-icons">person_add0</i> Create candidate</a>
    </div>
    <table class="striped">
      <thead>
        <tr>
          <th>Candidate Name</th>
          <th>Area</th>
          <th>Action </th>
        </tr>
      </thead>

      <tbody>
        <?php
        $sql = 'select c.id, c.name, a.name as areaName from candidate c, area a where c.area_id = a.id and c.party_id ='.$_SESSION['_id'];
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

          while ($obj = $result->fetch_object()) {
            echo '<tr>
                  <td>' . $obj->name . '</td>
                  <td>' . $obj->areaName . '</td>
                  <td>
                    <a href="#update' . $obj->id . '" class="btn center left-align green accent-4 waves-effect waves-light modal-trigger mb"><i class="material-icons">edit</i>Edit</a>
                    <a href="#delete' . $obj->id . '" class="btn center mb red waves-effect modal-trigger waves-light"><i class="material-icons">delete</i> Delete </a>
                  </td>
                </tr>';
          }
        } else {
          echo '<h3>Nothing show</h3>';
        }
        $result->close();
        ?>
      </tbody>
    </table>

    <?php
    $result = $conn->select('candidate');

    // echo $result->num_rows ;
    if ($result->num_rows > 0) {
      while ($obj = $result->fetch_object()) {
        $update = '
        <div id="update' . $obj->id . '" class="modal">
          <form method="POST" action="/party.php">
            <div class="modal-content">
            <h4>Edit the changes</h4>
            <table class="modal_table">
            <tbody>
              <input type="hidden" name="id" value="'.$obj->id.'"/>
              <tr class="modal_tr">
                <td>Name    : </td>
                <td><input type="text" name="name" value="' . $obj->name . '"/></td>
              </tr>
              <tr class="modal_tr">
                <td>Area Id : </td>
                <td><input type="number"  name="area_id" value="' . $obj->area_id . '"/></td>
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
            <a href="/party.php?id='.$obj->id.'" type="sumbit" class="modal-close waves-effect red white-text waves-green btn-flat"> <i class="material-icons">delete_forever</i>Delete</a>
          </div> 
        </div>';

        echo $update . '<br/>' . $delete;
      }
    }

    $result->close();
    ?>
  </div>
  <div id="createCandidate" class="modal">
    <div class="modal-content">
      <h4>Candidate Details</h4>
      <form class="row s12" action="/party.php" method="POST">
          <div class="input-field col s12">
            <input id="name" type="text" class="validate" name="name">
            <label for="name">Candidate Name</label>
          </div>
          <div class="input-field col s12">
            <input id="pwd" type="password" class="validate" name="password">
            <label for="pwd">Password</label>
          </div>
          <!-- <div class="input-field col s12">
            <input id="age" type="text" class="validate" name="age">
            <label for="age">Voter Age</label>
          </div> -->
          <div class="input-field col s12">
            <input id="area_id" type="text" class="validate" name="area_id">
            <label for="area_id">Area Id</label>
          </div>
          <div class="col s12 center login-btn">
            <button type="submit" name="candidate" class="btn btn-large waves-effect waves-light grey darken-3">Submit</button>
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
// create candiate
  if(isset($_POST['candidate'])){
      $candName = $_POST['name'];
      $candPwd = $_POST['password'];
      $candAreaId = $_POST['area_id'];
      $candPartyId = $_SESSION['_id'];
      $values = array(
        'name' => $candName,
        'password'=> $candPwd,
        'area_id' => $candAreaId,
        'party_id' => $candPartyId
      );

      $id = $conn->insert('candidate',$values);
      print_r('candidate is created'.$id);
  }

  if(isset($_POST['update'])){
    $values = array(
      'name' => $_POST['name'],
      'area_id' => $_POST['area_id']
    );
    $condition = array(
      'id' => $_POST['id']
    );

    $result = $conn->update('candidate', $values, $condition);
    echo "Successfully update";
    print_r($result);
  }

  if(isset($_GET['id'])){
    $value = array(
      'id' => $_GET['id']
    );
    // echo $_GET[id];
    $result = $conn->delete('candidate', $value);

    if($result){
      // header("Refresh:0");
      echo "successfully deleted";
    } else {
      echo $result;
    }
  }
}
else {
  header("location: login.php");
}
?> 
