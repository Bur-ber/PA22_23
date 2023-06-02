<html>

<head>

    <title>Evénements</title>

</head>
<body>
    <h1> Evénements </h1>
    
<?php 
    if(isConnected() && is_admin()){ ?>
        <a href="createEventForm.php">Créer un événement</a>
<?php
}
$eventCount = count_events();
$listOfEvents = get_listEvents();

if ($eventCount == 0) {
	echo 'Aucun sujet';
}
else{
	?>

	<table width="700">
    <tr>
        <td>
		Titre
		</td>
		<td>
		Place
		</td>
    	<td>
		Description
		</td>
    	<td>
		Début de l'événement
		</td>
        <td>
		Début des inscriptions
		</td>
		<?php if(is_admin()) { ?>
			<td>Actions</td>
		<?php } ?>
	</tr>
<?php
    foreach ($listOfEvents as $index => $event) {
        $startAt = get_time($event['start_date']);
        $registerAt = get_time($event['register_start']);
?>
<tr>
            <td><?= $event['title'] ?></td>
			<td><?= $event['place'] ?></td>
			<td><?= $event['description'] ?></td>
			<td><?= $startAt ?></td>
            <td><?= $registerAt ?></td>
			<td>
			<?php if(is_admin()) { ?> 
				<form action="actions/deleteEvent.php" method="post">
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

