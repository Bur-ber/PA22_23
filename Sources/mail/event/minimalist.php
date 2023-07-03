<!DOCTYPE html>
<html>
<head>
  <title>Nouvel événement à ne pas manquer !</title>
  <style>
    /* Styles CSS pour la mise en page et le style du contenu */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 4px;
    }

    h1 {
      color: #333333;
      font-size: 24px;
    }

    p {
      color: #666666;
      font-size: 16px;
    }

    .cta-button {
      display: inline-block;
      background-color: #ff6600;
      color: #ffffff;
      font-size: 16px;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Un nouvel événement à ne pas manquer !</h1>

    <p>Nous sommes ravis de vous annoncer notre prochain événement qui se tiendra le <?php echo $_SESSION['optEvent']['start']; ?> à <?php echo $_SESSION['optEvent']['place']; ?>.</p>

    <p>Rejoignez-nous pour une journée remplie d'activités passionnantes, de conférences inspirantes et de rencontres enrichissantes. Cet événement est conçu pour <?php echo $_SESSION['optEvent']['desc']; ?>.</p>

    <p>Ne manquez pas cette opportunité de vous connecter avec d'autres passionnés et d'en apprendre davantage.</p>

    <a class="cta-button" href="livryescalade.helioserv.fr/event.php">En savoir plus</a>

    <p>Nous espérons vous voir nombreux lors de cet événement inoubliable. Réservez dès maintenant votre place.</p>

    <p>Cordialement,<br>L'équipe de Livry Escalade</p>
  </div>
</body>
</html>

<?php
  unset($_SESSION['optEvent']);
?>
