<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="nav-collapse">
        <ul class="nav">
          <li><a href="./index.php">Acceuil</a></li>
          <li><a href="#">Activités</a></li>

          
          <?php
          if (isset($_SESSION['type'])) {
          ?>

            
            <li><a href="./mon_compte.php?c=default">Mon compte</a></li>

            <?php
            if ($_SESSION['type'] == "admin") {
            ?>


              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration</a>
                <ul class="dropdown-menu">
                  <li><a href="./client_admin.php">Clients</a></li>
                  <li><a href="#">Réservations</a></li>
                  <li><a href="#">Chalets</a></li>
                  <li><a href="#">Saisons</a></li>
                  <li><a href="#">Semaines</a></li>
                  <li><a href="./type_chalet.php">Types</a></li>


                </ul>
              </li>

          <?php
            }
          }
          ?>





        </ul>

      </div><!-- /.nav-collapse -->
    </div>
  </div><!-- /navbar-inner -->
</div>