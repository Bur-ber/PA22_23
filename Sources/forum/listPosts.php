<html>

<head>

    <title>Index de notre forum</title>

</head>
<body>



<!-- on place un lien permettant d'accéder à la page contenant le formulaire d'insertion d'un nouveau sujet -->

<a href="createPostForm.php">Créer un post</a>

<?php

// on se connecte à notre base de données
$connect = connectDB();

// préparation de la requete + on lance la requête 
$query = $connect -> query("SELECT COUNT(*) as total_posts FROM ".PRE_DB."post");
$postCount = $query ->fetch();
$query = $connect -> query("SELECT ".PRE_DB."post.title, ".PRE_DB."post.id as post_id, ".PRE_DB."post.created_at, ".PRE_DB."user.mail  FROM ".PRE_DB."post 
INNER JOIN ".PRE_DB."user ON ".PRE_DB."user.id = ".PRE_DB."post.user_id  ORDER BY created_at DESC");

$listOfPosts = $query ->fetchAll();



// on compte le nombre de sujets du forum
if ($postCount == 0) {
	echo 'Aucun sujet';
}

else{
	?>

	<table width="700">
    <tr>
		<td>
			Auteur
		</td>
    	<td>
		Titre du sujet
		</td>
    	<td>
		Date de création
		</td>
		<?php if(is_admin()) { ?>
			<td>Actions</td>
		<?php } ?>
	</tr>
<?php
	// on va scanner tous les tuples un par un
	foreach ($listOfPosts as $index => $post) {
		sscanf($post['created_at'], "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde);
?>
		
		<tr>
			<td><?= $post['mail'] ?></td>
			<td><a href="?post=<?= $post['post_id']; ?>"><?= $post['title'] ?></a></td>
			<td><?= $jour , '-' , $mois , '-' , $annee , ' ' , $heure , ':' , $minute ?></td>
			<td>
			<?php if(is_admin()) { ?> 
				<form action="actions/deletePost.php" method="post">
					<input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
					<button type="submit">Supprimer</button>
				</form>	
			<?php }?>
			</td>
		</tr>

	<?php }
	}


		
	?>

	</td></tr></table>
</body>

</html>
