<!DOCTYPE html>
<html>
<head>
  <title>Nouveau produit disponible !</title>
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
    <h1>Un nouvel objet est disponible !</h1>

    <p>Cher(e) abonné(e), nous sommes ravis de vous présenter notre dernier ajout à la boutique en ligne : <?php echo $_SESSION['optShop']['name']; ?>.</p>

    <img src="<?php echo $_SESSION['optShop']['image']; ?>" alt="Image de l'objet" width="400" height="400">

    <p>Cet objet incroyable est un must-have pour tous les passionnés. Voici quelques points forts :</p>

    <p><?php echo $_SESSION['optShop']['desc']; ?>.</p>

    <p>Ne manquez pas cette opportunité de compléter votre collection !</p>

    <a class="cta-button" href="livryescalade.helioserv.fr/shop.php">Découvrez-le maintenant</a>

    <p>Merci pour votre soutien continu. Nous espérons que vous apprécierez cette nouvelle addition à notre boutique en ligne.</p>

    <p>Bien cordialement,<br>L'équipe de Livry Escalade</p>
  </div>
</body>
</html>

<?php
  unset($_SESSION['optShop']);
?>
