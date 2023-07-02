<?php
	session_start();
	require 'const.php';
	require 'functions.php';

  $statusRequired = 4;
  redirectIfNotConnected($statusRequired);

  if (!empty($_POST['time'])
  && !empty($_POST['shop'])
  && !empty($_POST['event'])
  && !empty($_POST['optShop'])
  && !empty($_POST['optEvent'])
) {
  // Verifier les valeurs puis modifier les fichiers
}
