<?php
	session_start();
	require 'const.php';
	require 'functions.php';

  $statusRequired = 1;
  redirectIfNotConnected($statusRequired);

  require '/home/debian/vendor/autoload.php';

  $mail = new PHPMailer\PHPMailer\PHPMailer(true);

  try {
    //Server settings
    $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'livryescalade@outlook.fr';                     //SMTP username
    $mail->Password   = '8Unt$U{7*9eKp9';                               //SMTP password
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMai>

    //Recipients
    $mail->setFrom('livryescalade@outlook.fr', 'Administrateur mail');
    $mail->addAddress($_SESSION['mail']);     //Add a recipient

      //Attachments

      //Content
      $mail->charSet = "UTF-8";
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Lien de confirmation d\'email';
      $mail->Body    = 'Bonjour,<br>Ceci est un message automatique, vous trouverez le lien de vérification d\'email ci-dessous <a href="livryescalade.helioserv.fr/core/verifyMail.php?id='. $_SESSION['id'] .'">Vérifier votre adresse mail</a>';
      $mail->AltBody = 'Bonjour,
      Ceci est un message automatique, vous trouverez le lien de vérification d\'email ci-dessous : livryescalade.helioserv.fr/core/verifyMail.php?id='. $_SESSION['id'];

      $mail->send();
			header('Location: ../account.php');
      echo 'Message has been sent';
  } catch (Exception $e) {
		header('Location: ../account.php');
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
