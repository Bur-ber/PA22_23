<?php
  session_start();
  require '../core/const.php';
  require '../core/functions.php';
  include '../templates/header.php';

  $time = fgetc(fopen('time.txt', 'rb'));

  $queryPrepared = $connection -> query("SELECT mail, last_connection FROM ". PRE_DB ."USER");
  $result = $queryPrepared -> fetchAll();

  foreach ($result as $value) {
    if ($value['last_connection'] + 30 * $time <= time()) {
      sendMail(MAIL['absent'], $value['mail']);
    }
  }
