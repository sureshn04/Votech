<?php
  require_once __DIR__.'/../vendor/autoload.php';
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
    <div class="row card hoverable">
      <div class="card-content ">
        <h4 class="center black-text">Votech</h4>
        <form class="row s12" action="/login.php" method="POST">
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate">
            <label for="last_name">Username</label>
          </div>
          <div class="input-field col s12">
            <input id="last_name" type="text" class="validate">
            <label for="last_name">Password</label>
          </div>
          <div class="col s12">
            <!-- <p><label><input type="checkbox"></label></p> -->
          </div>
          <div class="col s12 center login-btn">
            <button type="submit" class="btn btn-large waves-effect waves-light grey darken-3">Login</button>
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