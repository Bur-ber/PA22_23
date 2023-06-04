<?php
  session_start();
  require 'const.php';
  require 'functions.php';
  require('../../Resources/FPDF/fpdf.php');
  $statusRequired = 1;
  redirectIfNotConnected($statusRequired);

  $pdf = new FPDF();
  $connection = connectDB();

  // Section Profil
  $queryPrepared = $connection -> prepare("SELECT * FROM ". PRE_DB ."USER WHERE id=:id");
  $queryPrepared -> execute(['id' => $_SESSION['id']]);
  $profile = $queryPrepared -> fetch(PDO::FETCH_ASSOC);
  $titre = 'Informations de '. $profile['firstname'] .' '. $profile['lastname'];
  $pdf->SetTitle($titre);
  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 12);
  $pdf->SetFillColor(200, 220, 255);
  $pdf->Cell(0, 6, "Informations du profil", 0, 1, 'L', true);
  $pdf->Ln(4);
  $pdf->SetFont('Times','',12);

  foreach ($profile as $key => $value) {
    $pdf->Cell(0, 6, $key .' : '. $value, 0, 1, 'L', true);
    $pdf->Ln();
  }

  $pdf->Cell(0,5,"(fin du profil)");


  // Section Event
  $queryPrepared = $connection -> prepare("SELECT * FROM ". PRE_DB ."JOIN WHERE user=:id");
  $queryPrepared -> execute(['id' => $_SESSION['id']]);
  $event = $queryPrepared -> fetchAll(PDO::FETCH_ASSOC);
  if (!empty($event)) {
    $queryEvent = $connection -> prepare("SELECT name FROM ". PRE_DB ."EVENT WHERE id=:id");
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(0, 6, "Evènements rejoins", 0, 1, 'L', true);
    $pdf->Ln(4);
    $pdf->SetFont('Times','',12);
    foreach ($event as $key => $value) {
      $queryEvent -> execute(['id' => $value['event']]);
      $nameEvent = $queryEvent -> fetch(PDO::FETCH_ASSOC);
      $pdf->Cell(0, 6, $nameEvent['name'], 0, 1, 'L', true);
      $pdf->Ln();
    }
    $pdf->Cell(0,5,"(fin des évènements)");
  }


  // Section Shop
  $queryPrepared = $connection -> prepare("SELECT * FROM ". PRE_DB ."BUY WHERE user=:id");
  $queryPrepared -> execute(['id' => $_SESSION['id']]);
  $shop = $queryPrepared -> fetchAll(PDO::FETCH_ASSOC);
  if (!empty($shop)) {
    $queryMaterial = $connection -> prepare("SELECT name FROM ". PRE_DB ."MATERIAL WHERE id=:id");
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(0, 6, "Achat effectué", 0, 1, 'L', true);
    $pdf->Ln(4);
    $pdf->SetFont('Times','',12);
    foreach ($shop as $key => $value) {
      $queryMaterial -> execute(['id' => $value['material']]);
      $nameMaterial = $queryMaterial -> fetch(PDO::FETCH_ASSOC);
      $pdf->Cell(0, 6, $nameMaterial['name'] .' : '. $value['quantity'], 0, 1, 'L', true);
      $pdf->Ln();
    }
    $pdf->Cell(0,5,"(fin des achats)");
  }


  // Section Rent
  $queryPrepared = $connection -> prepare("SELECT * FROM ". PRE_DB ."RENT WHERE user=:id");
  $queryPrepared -> execute(['id' => $_SESSION['id']]);
  $shop = $queryPrepared -> fetchAll(PDO::FETCH_ASSOC);
  if (!empty($shop)) {
    $queryMaterial = $connection -> prepare("SELECT name FROM ". PRE_DB ."MATERIAL WHERE id=:id");
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(0, 6, "Location effectuée", 0, 1, 'L', true);
    $pdf->Ln(4);
    $pdf->SetFont('Times','',12);
    foreach ($shop as $key => $value) {
      $queryMaterial -> execute(['id' => $value['material']]);
      $nameMaterial = $queryMaterial -> fetch(PDO::FETCH_ASSOC);
      $pdf->Cell(0, 6, $nameMaterial['name'] .' : '. $value['quantity'], 0, 1, 'L', true);
      $pdf->Ln();
    }
    $pdf->Cell(0,5,"(fin des locations)");
  }


  // Section Post ?




  //$pdf->SetAuthor('Jules Verne');
  $pdf->Output('D', $titre .'.pdf');
  //header("Location: ../account.php") pas besoin de header apparemment
?>
