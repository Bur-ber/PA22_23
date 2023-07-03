<?php
	session_start();
	require "core/const.php";
	require "core/functions.php";
	include "templates/header.php";
	$statusRequired = 4;

	redirectIfNotConnected($statusRequired);
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$_POST["actions"](intval($_GET["event"]));
		$message = "Action effectuée avec succès";
	}
	addToLogVisit("Panel Admin");
?>
<h1>Panel administrateur</h1>

<?php if(isset($message)){ ?>
	<p><?= $message ?></p>
<?php } ?>

<?php
	$connect = connectDB();
	$query = $connect -> query("SELECT * FROM " .PRE_DB."EVENT WHERE start_date >=CURDATE() ORDER BY start_date ASC");
	$listOfEvents = $query -> fetchAll();

?>
<a href="adminPanelArchives.php">Evénements archivés</a>
<a href="adminPanel.php">Utilisateurs</a>

<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Titre</th>
			<th>Type</th>
			<th>Localisation</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>places disponibles</th>
            <th>prix</th>
			<th>Actions</th>
			<th>Confirmer l'action</th>
		</tr>
	</thead>
	<tbody>
        
		<?php
        foreach($listOfEvents as $index => $event)
        {
          $startAt = get_time($event['start_date']);
        ?>
        <tr class="col-md-4">
            <td><?= $event['id'] ?></td>
            <td><?= $event['name'] ?></td>
            <td><?= $event['type'] ?></td>
            <td><?= $event['place'] ?></td>
            <td><?= $event['start_date'] ?></td>
            <td><?= $event['end_date'] ?></td>
            <td><?= $event['nbr_space'] ?></td>
            <td><?= $event['price'] ?></td>
       
        <form method="POST" action="adminPanelEvents.php?event=<?php echo $event["id"]?>">
						<td>
							<select name="actions" class="select">
								<option class='btn' value="delEvent">Supprimer</option>
								<option class='btn' value="modifyEvent">Modifier</option>
							</select>
						</td>	
						<td>
							<button><input type="submit" value="Confirmer" class="btn"></button>
						</td>
					</form>
                    <?php
        }
        ?>

	</tbody>
</table>


<?php include "templates/footer.php"; ?>
