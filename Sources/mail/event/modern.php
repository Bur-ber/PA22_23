<!DOCTYPE html>
<html>
<head>
  <title>Invitation à un nouvel événement</title>
  <style>
    /* Styles CSS pour la mise en page et le style du contenu */
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #333333;
      font-size: 28px;
      margin-top: 0;
    }

    p {
      color: #666666;
      font-size: 18px;
      line-height: 1.5;
    }

    .cta-button {
      display: inline-block;
      background-color: #ff6600;
      color: #ffffff;
      font-size: 18px;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 4px;
      margin-top: 24px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Vous êtes invité à un nouvel événement passionnant !</h1>

    <p>Cher(e) abonné(e), nous sommes heureux de vous inviter à notre prochain événement qui aura lieu le <?php echo $_SESSION['optEvent']['start']; ?> à <?php echo $_SESSION['optEvent']['place']; ?>.</p>

    <p>Cet événement unique en son genre sera l'occasion parfaite de <?php echo $_SESSION['optEvent']['desc']; ?>.</p>

    <p>Nous avons préparé une journée riche en découvertes, conférences inspirantes et opportunités de réseautage. Vous aurez la chance d'interagir avec des experts du domaine et de rencontrer d'autres passionnés.</p>

    <a class="cta-button" href="livryescalade.helioserv.fr/event.php">Réservez votre place</a>

    <p>Les places étant limitées, nous vous recommandons de vous inscrire dès maintenant pour garantir votre participation.</p>

    <p>Nous avons hâte de vous retrouver lors de cet événement exceptionnel et de partager des moments inoubliables avec vous.</p>

    <p>Cordialement,<br>L'équipe de Livry Escalade</p>
  </div>
</body>
</html>

<?php
  unset($_SESSION['optEvent']);
?>
