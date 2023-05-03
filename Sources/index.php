<?php
  session_start();
  require 'core/const.php';
  require "core/functions.php";
  include "views/templates/header.php"; 
  ?>

  <div class="row" id="main">
    <div class="col-md-4" id="bio">
      <h2>Bienvenue à Livry Escalade</h2>
      <p>Le club qui vous permettra d’apprécier l’art de l’escalade, que ce soit en extérieur ou en intérieur !<br><br>
        Inscrivez vous sur notre site afin de rejoindre la communauté de Livry escalade</p>
      <a href="register.php" class="site-Btn">S'inscrire</a>

    </div>

    <div class="col-md-4" id="calendar">
      <table>
        <tr>
          <th>Calendrier</th>
        </tr>
        <tr>
          <td><?php 
            $fmt = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
            $fmt->setPattern('dd MMMM YYYY');
            echo $fmt->format(new DateTime() ); 

           ?>
          </td>
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>
  </div>
</body>

<?php include 'views/templates/footer.php'; ?>
