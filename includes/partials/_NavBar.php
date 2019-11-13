
<header >
    <nav class="grey darken-4">
      <div class="nav-wrapper container">
        <a href="/" class="brand-logo">Votech</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
          <!-- <li><a href="/">Results</a></li> -->
          <?php
            // echo $_SESSION['role'];
            if(isset($_SESSION['role'])) {
              echo '<li><a href="/'.$_SESSION['role'].'.php">'.$_SESSION["name"] .'</a></li>';
              echo '<li><a href="/logout.php">logout</a></li>';
            } else {
              echo '<li><a href="/login.php">login</a></li>';
            }
          ?>

          
        </ul>
      </div>
      <ul class="sidenav" id="mobile-demo">
          <li><a href="sass.html">Sass</a></li>
          <li><a href="badges.html">Components</a></li>
          <li><a href="collapsible.html">Javascript</a></li>
          <li><a href="mobile.html">Mobile</a></li>
        </ul>
    </nav>
  </header>
