<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php'; 
  include 'Calendar.php';

  ?>

  <div class="row" id="main">
    <div class="col-md-4" id="bio">
      <h2><b>Bienvenue à Livry Escalade</b></h2>
      <p>Le club qui vous permettra d’apprécier l’art de l’escalade, que ce soit en extérieur ou en intérieur !<br><br>
        Inscrivez vous sur notre site afin de rejoindre la communauté de Livry escalade</p>
      <a href="register.php" class="site-Btn">S'inscrire</a>

    </div>

    <div class="col-md-1" id="calendar">
      <table>
        <tr>
          <th style="font-size:24px;" >Calendrier</th>
        </tr>
        <tr>
          <td ><b><?php 
            $fmt = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
             $fmt->setPattern('dd MMMM YYYY');
             echo $fmt->format(new DateTime() ); 
           ?>
          </b></td>
        </tr>
      </table>
    </div>
    

  </div>
</body>

<?php include 'templates/footer.php'; ?>
