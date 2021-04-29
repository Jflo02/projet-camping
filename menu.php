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
          <li><a href="./index.php">Accueil</a></li>
          <li><a href="./activites.php">Activités</a></li>
          <li><a href="./chalet.php">Nos chalets</a></li>
          <li><a href="./promo.php">Promos</a></li>


          <?php
          if (isset($_SESSION['type'])) {


            if ($_SESSION['type'] == "client") {
          ?>
              <li><a href="./mon_compte.php?c=default">Mon compte</a></li>

            <?php
            }
            if ($_SESSION['type'] == "admin") {
            ?>


              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration</a>
                <ul class="dropdown-menu">
                  <li><a href="./client_admin.php?c=defaut">Clients</a></li>
                  <li><a href="./reservations_admin.php?c=defaut">Réservations</a></li>
                  <li><a href="./chalet_admin.php?c=defaut">Chalets</a></li>
                  <li><a href="./saisons.php?c=default">Saisons</a></li>
                  <li><a href="./semaine_admin.php">Semaines</a></li>
                  <li><a href="./type_chalet.php?c=defaut">Types</a></li>


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