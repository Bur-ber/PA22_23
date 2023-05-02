<?php
session_start();
$listImg = glob('images/forCaptcha/*.jpg');

$image = $listImg[array_rand($listImg)];

$size = 100; // Taille des carrés
$captchaPieces = []; // Tableau pour stocker les morceaux de l'image

// Charge l'image
$img = imagecreatefromjpeg($image);

// Récupère les dimensions de l'image
$width = 300;
$height = 300;

// Découpe l'image en plusieurs carrés et les stocke dans le tableau $pieces
for ($x = 0; $x < $width; $x += $size) {
    for ($y = 0; $y < $height; $y += $size) {
        $piece = imagecreatetruecolor($size, $size);
        imagecopy($piece, $img, 0, 0, $x, $y, $size, $size);
        $pieces[] = $piece;
    }
}

$piecesPath = 'images/forCaptcha/captchaPieces/';

if (!file_exists($piecesPath)) {
    mkdir($piecesPath, 0777, true);
}else {
  $piecesPath = glob('images/forCaptcha/captchaPieces/*.jpg');
  foreach ($piecesPath as $pieceInRep){
    unlink($pieceInRep);
  }
}

// Boucle à travers les morceaux de l'image
foreach ($pieces as $piece) {
    // Génère un nom de fichier unique pour chaque morceau
    $filename = 'captcha_piece_' . bin2hex(random_bytes(5)) . '.jpg'; // bin2hex(random_bytes(5)) permet de générer une chaine aléatoire, pas besoin de shuffle comme ça :P
    // Enregistre le morceau en tant que fichier image dans le dossier
    imagejpeg($piece, $piecesPath . $filename);
    // Stocke le nom de fichier dans un tableau pour pouvoir le récupérer plus tard
    $filenames[] = $filename;
}

$_SESSION['rightOrder'] = serialize($filenames);
$_SESSION['image'] = $image;

header("Location: registerPart3.php");
