<?php
	session_start();
	require 'core/const.php';
	require 'core/functions.php';
  include 'templates/header.php';

  $statusRequired = 4;
  redirectIfNotConnected($statusRequired);

  $event = glob('mail/event/*.php');
  $shop = glob('mail/shop/*.php');
  $time = fgetc(fopen('time.txt', 'rb'));

  ?>

  <form class="modify-news" action="core\modifyNews.php" method="post">

    <label for="time">Mail d'inactivité (Pour éviter de spammer les utilisateurs, les périodes sont en mois)</label>
    <select class="time" name="time">
      <option value="1">1 mois</option>
      <option value="2">2 mois</option>
      <option value="3">3 mois</option>
      <option value="6">6 mois</option>
      <option value="12">12 moins (1 an)</option>
    </select>

    <label for="shop">Template mail de nouvel objet</label>
    <select class="shop" name="shop">
      <?php foreach ($shop as $key => $value) { ?>
        <option value="<?php echo $key; ?>"><?php echo basename($value, ".php") ?></option>
      <?php } ?>
    </select>

    <label for="shop">Template mail de nouvel évènements</label>
    <select class="shop" name="shop">
      <?php foreach ($event as $key => $value) { ?>
        <option value="<?php echo $key; ?>"><?php echo basename($value, ".php") ?></option>
      <?php } ?>
    </select>

    <input type="text" name="optShop" value="<?php echo $shop ?>" hidden>
    <input type="text" name="optEvent" value="<?php echo $event ?>" hidden>
  </form>
