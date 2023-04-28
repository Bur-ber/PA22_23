<?php
  session_start();
  require 'core/const.php';
  require "core/functions.php";
  include "templates/header.php"; ?>

<div class="row" id="main">
  <div class="col-md-6" id="bio">
    <h2>Bienvenue à Livry Escalade</h2>
    <p>Le club qui vous permettra d’apprécier l’art de l’escalade, que ce soit en extérieur ou en intérieur !<br><br>
      Inscrivez vous sur notre site afin de rejoindre la communauté de Livry escalade</p>
    <a href="register.php" class="btn btn-light">S'inscrire</a>

  </div>

  <div class="col-md-6" id="calendar">
    <table>
      <tr>
        <th>Calendrier</th>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
  </div>
</div>

<?php include 'templates/footer.php'; ?>
