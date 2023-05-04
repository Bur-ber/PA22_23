<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php'; 
  ?>

<html>

<head>

    <title>Index de notre forum</title>

</head>
<body>



<!-- on place un lien permettant d'accéder à la page contenant le formulaire d'insertion d'un nouveau sujet -->

<a href="./createPost.php">Créer un post</a>

<?php

// on se connecte à notre base de données
$connect = connectDB();

// préparation de la requete + on lance la requête 
$query = $connect -> query("SELECT * FROM ".PRE_DB."forumposts ORDER BY last_answered DESC");
$listOfPosts = $query ->fetchAll();
echo json_encode($listOfPosts);
// on compte le nombre de sujets du forum
$nb_sujets = mysqli_num_rows($listOfPosts);
if ($nb_sujets == 0) {

	echo 'Aucun sujet';

}

else {

	?>

	<table width="500">
    <tr>

	    <td>
	      Auteur
      </td>
      <td>
        Titre du sujet
      </td>
      <td>
      Date dernière réponse
      </td>
    </tr>

	<?php

	// on va scanner tous les tuples un par un

	while ($data = mysql_fetch_array($listOfPosts)) {



	// on décompose la date

	sscanf($data['last_answered'], "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde);



	// on affiche les résultats

	echo '<tr>';

	echo '<td>';



	// on affiche le nom de l'auteur de sujet

	echo htmlentities(trim($data['author']));

	echo '</td><td>';



	// on affiche le titre du sujet, et sur ce sujet, on insère le lien qui nous permettra de lire les différentes réponses de ce sujet

	echo '<a href="./readPost.php?id_sujet_a_lire=' , $data['id'] , '">' , htmlentities(trim($data['title'])) , '</a>';



	echo '</td><td>';



	// on affiche la date de la dernière réponse de ce sujet

	echo $jour , '-' , $mois , '-' , $annee , ' ' , $heure , ':' , $minute;

	}

	?>

	</td></tr></table>

	<?php

}



// on libère l'espace mémoire alloué pour cette requête

mysql_free_result ($listOfPosts);

// on ferme la connexion à la base de données.

mysql_close ();
?>

</body>

</html>
