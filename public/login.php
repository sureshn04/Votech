<?php
  session_start();
  require_once __DIR__.'/../vendor/autoload.php';
  $logger = Logger::getLogger();

  $error = null;
  if(isset($_POST['submit']))
  {
    if (empty($_POST['username'] )|| empty($_POST['password'])){
      $error = "username or password is invalid";
    } else {
      $username = $_POST['username'];
      $password = $_POST['password'];

      // To protect MySQL injection for Security purpose
      $username = stripslashes($username);
      $password = stripslashes($password);
      // $username = mysql_real_escape_string($username);
      // $password = mysql_real_escape_string($password);

      $role;

      switch($username[0]){
        case '1': $role = "admin";
                  break;
        case '2': $role = "party";
                  break;
        case '3': $role = "candidate";
                  break;
        case '4': $role = "voter";
                  break;
        default : $role = null;
      }

      if($role != null){
        $logger->pushToInfo($role);
        $conn = votechDB::getConnection();

        // TODO check if the $result is present or false
        $result = $conn->select($role, array('id','name'), array("password"=> $password, "id"=>$username));
        // print_r(json_encode($result));
        // echo "   ".$result->num_rows;
        if($result->num_rows == 0){

          $error = "Invalid username or password";
        } else {

          $row = $conn->row($result);//Array ( [0] => 1000 [1] => admin )
          $_SESSION['role'] = $role;
          $_SESSION['_id'] = $row[0]; 
          $_SESSION['name'] = $row[1];
          switch($role){
            case 'admin': header("location: admin.php");
                          break;
            case 'party': header("location: party.php");
                          break;
            case 'voter': header("location: voter.php");
                          break;
            default: header("location: index.php");                            
          }      
          // header("location: index.php");
        }
          
      } else {
        $error = "Invalid username";
      }
    }
    $logger->pushToError($error);
    // echo $error;
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    require_once __DIR__.'/../includes/partials/_head.php';
  ?>
  <title>Votech</title>
</head>

<body>
  <?php require_once __DIR__.'/../includes/partials/_NavBar.php'; ?>

  <section id="login" class="container">
  <?php
    if($error){
      echo '<h6 class="display-4 red-text text-center">'.$error.'</h6>';
    }
   ?>
    <div class="row card hoverable">
      <div class="card-content ">
        <h4 class="center black-text">Votech</h4>
        <form class="row s12" action="/login.php" method="POST">
          <div class="input-field col s12">
            <input id="name" type="text" class="validate" name="username">
            <label for="name">Username</label>
          </div>
          <div class="input-field col s12">
            <input id="pwd" type="password" class="validate" name="password">
            <label for="pwd">Password</label>
          </div>
          <div class="col s12">
            <!-- <p><label><input type="checkbox"></label></p> -->
          </div>
          <div class="col s12 center login-btn">
            <button type="submit" name="submit" class="btn btn-large waves-effect waves-light grey darken-3">Login</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var elems = document.querySelectorAll('.sidenav');
      var instances = M.Sidenav.init(elems);
    });
  </script>
</body>

</html>