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
$query = $connect -> query("SELECT COUNT(*) as total_posts FROM ".PRE_DB."POST");
$postCount = $query ->fetch();
$query = $connect -> query("SELECT ".PRE_DB."POST.title, ".PRE_DB."POST.id as post_id, ".PRE_DB."POST.created_at, ".PRE_DB."USER.mail  FROM ".PRE_DB."POST 
INNER JOIN ".PRE_DB."USER ON ".PRE_DB."USER.id = ".PRE_DB."POST.user_id  ORDER BY created_at DESC");

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
		$createdAt = get_time($post['created_at']);
?>
		
		<tr>
			<td><?= $post['mail'] ?></td>
			<td><a href="?post=<?= $post['post_id']; ?>"><?= $post['title'] ?></a></td>
			<td><?= $createdAt; ?></td>
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
