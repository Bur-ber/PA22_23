<?php
	session_start();
	require "core/const.php";
	require "core/functions.php";
	include "templates/header.php";
	$statusRequired = 4;

	redirectIfNotConnected($statusRequired);
?>

<h1>Panel administrateur</h1>

<?php
	$connect = connectDB();
	$query = $connect -> query("SELECT * FROM " .PRE_DB."USER");
	$listOfUsers = $query -> fetchAll();

?>

<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Genre</th>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Email</th>
			<th>Ville</th>
			<th>Date de naissance</th>
			<th>Statut</th>
			<th>Ajout</th>
			<th>Modification</th>
			<th>Actions</th>
			<th>Confirmer l'action</th>
		</tr>
	</thead>
	<tbody>

		<?php
		foreach($listOfUsers as $index => $user){
			if($user["updated_at"] == '1000-01-01 00:00:00')$user["updated_at"] = $user["created_at"];
			?>
			<tr>
				<td><?=$user["id"]?></td>
				<td><?=$user["gender"]?></td>
				<td><?=$user["firstname"]?></td>
				<td><?=$user["lastname"]?></td>
				<td><?=$user["mail"]?></td>
				<td><?=$user["city"]?></td>
				<td><?=$user["birthday"]?></td>
				<td><?=$user["status"]?></td>
				<td><?=$user["created_at"]?></td>
				<td><?=$user["updated_at"]?></td>
			<?php if($user["status"] == 0){?>
				<class="select" name="actions">
					<form action="adminPanel.php">
						<select>
							<option class='btn btn-danger' href='core/delUsers.php?id="<?php $user["id"]?>"'>Supprimer</option>
							<option class='btn btn-danger' href='core/unbanUsers.php?id="<?php $user["id"]?>"'>Débannir</option>
						</select>
					</form>
				</td>
			</tr>
			<?php
			}else{?>
					<form action="adminPanel.php">
						<select>
							<option class='btn btn-danger' href='core/delUsers.php?id="<?php $user["id"]?>"'>Supprimer</option>
							<option class='btn btn-danger' href='core/banUsers.php?id="<?php $user["id"]?>"'>Bannir</option>
							<option class='btn btn-danger' href='core/ModAssign.php?id="<?php $user["id"]?>"'>Nommer Modérateur</option>
							<option class='btn btn-danger' href='core/adminAssign.php?id="<?php $user["id"]?>"'>Nommer Administrateur</option>
						</select>
					</form>
				<button>
			</tr>
		<?php
		}

		}
		?>

	</tbody>
</table>


<?php include "templates/footer.php"; ?>
