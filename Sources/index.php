<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';

  $eventCount = count_events();
  $listOfEvents = get_listEvents();
  addToLogVisit("Accueil");

  ?>

  <div class="row" id="main">
    <div id="bio">
      <h2><b>Bienvenue à Livry Escalade</b></h2>
      <p>Le club qui vous permettra d’apprécier l’art de l’escalade, que ce soit en extérieur ou en intérieur !<br><br>
        Inscrivez vous sur notre site afin de rejoindre la communauté de Livry escalade</p>
      <a href="register.php" class="site-Btn">S'inscrire</a>

    </div>

    <div id="calendar">
      <table>
        <tr>
          <th>Calendrier</th>
        </tr>
        <tr>
          <td><b><?php
             echo date("d/m/Y")
           ?>
          </b></td>
        </tr>
        <tr>
          <td>Type</td>
          <td>Titre</td>
          <td>Lieu</td>
          <td>Date</td>
        </tr>
        <tr>
          <td><?php
            if ($eventCount == 0)
            {
              echo 'Aucun sujet';
            }else{
              $i = 0;
              foreach($listOfEvents as $index => $event)
              {
                if($i>4){
                  break;
                }
                $startAt = get_time($event['start_date']);
              ?>
        <tr class="col-md-4">
          <td><?= $event['type'] ?></td>
          <td><?= $event['name'] ?></td>
          <td><?= $event['place'] ?></td>
          <td><?= $startAt ?></td>
          <td>
            <a href="readEvent.php?id=<?=$event['id']?>" id="calendar-Btn">En savoir +</a>
          </td>
          <?php
            $i++;
              }
            }
          ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>

<?php include 'templates/footer.php'; ?>
