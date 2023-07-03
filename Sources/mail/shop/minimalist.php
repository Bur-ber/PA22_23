<!DOCTYPE html>
<html>
<head>
  <title>Nouvel objet ajouté !</title>
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
    <h1>Nouvel objet ajouté à notre boutique en ligne !</h1>

    <p>Nous sommes ravis de vous annoncer l'arrivée d'un nouvel objet passionnant dans notre collection. Découvrez-le dès maintenant :</p>

    <h2>Nom de l'objet : <?php echo $_SESSION['optShop']['name']; ?></h2>

    <img src="<?php echo $_SESSION['optShop']['image']; ?>" alt="Image de l'objet" width="300" height="300">

    <p>Description de l'objet : <?php echo $_SESSION['optShop']['desc']; ?></p>

    <p>Ne manquez pas l'opportunité de vous procurer cet objet unique dès maintenant !</p>

    <a class="cta-button" href="livryescalade.helioserv.fr/shop.php">Découvrir l'objet</a>

    <p>Merci de votre fidélité et à bientôt sur notre boutique en ligne.</p>

    <p>Cordialement,<br>L'équipe de Livry Escalade</p>
  </div>
</body>
</html>

<?php
  unset($_SESSION['optShop']);
?>
