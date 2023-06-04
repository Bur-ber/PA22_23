<?php
	session_start();
	require "core/const.php";
	require "core/functions.php";
	include "templates/header.php";
	$statusRequired = 4;

	redirectIfNotConnected($statusRequired);
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$_POST["actions"](intval($_GET["user"]));
		$message = "Action effectuée avec succès";
	}
?>
<h1>Panel administrateur</h1>

<?php if(isset($message)){ ?>
	<p><?= $message ?></p>
<?php } ?>

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
				<form method="POST" action="adminPanel.php?user=<?php echo $user["id"]?>">
					<td>
						<select name="actions" class="select">
							<option class='btn' value="delUser">Supprimer</option>
							<option class='btn' value="assignUser">Débannir</option>
						</select>
					</td>
					<td>
						<button><input type="submit" value="Confirmer" class="btn"></button>
					</td>
				</form>
			</tr>
			<?php
			}elseif($user["status"] == 1){?>
					<form method="POST" action="adminPanel.php?user=<?php echo $user["id"]?>">
						<td>
							<select name="actions" class="select">
								<option class='btn' value="delUser">Supprimer</option>
								<option class='btn' value="banUser">Bannir</option>
								<option class='btn' value="assignMod">Nommer Modérateur</option>
								<option class='btn' value="assignAdmin">Nommer Administrateur</option>
								<option class='btn' value="assignTeacher"> Nommer Formateur</option>
							</select>
						</td>	
						<td>
							<button><input type="submit" value="Confirmer" class="btn"></button>
						</td>
					</form>
				</tr>
				
		<?php
			}elseif($user["status"] == 2){?>
					<form method="POST" action="adminPanel.php?user=<?php echo $user["id"]?>">
						<td>
							<select name="actions" class="select">
								<option class='btn' value="delUser">Supprimer</option>
								<option class='btn' value="banUser">Bannir</option>
								<option class='btn' value="assignMod">Nommer Modérateur</option>
								<option class='btn' value="assignAdmin">Nommer Administrateur</option>
								<option class='btn' value="assignUser">Déstituer Formateur</option>
							</select>
						</td>	
						<td>
							<button><input type="submit" value="Confirmer" class="btn"></button>
						</td>
					</form>
				</tr>
				
		<?php
		}
			elseif($user["status"] == 3){?>
				<form method="POST" action="adminPanel.php?user=<?php echo $user["id"]?>">
					<td>
						<select name="actions" class="select">
							<option class='btn' value="delUser">Supprimer</option>
							<option class='btn' value="banUser">Bannir</option>
							<option class='btn' value="assignUser">Déstituer Modérateur</option>
							<option class='btn' value="assignAdmin">Nommer Administrateur</option>
							<option class='btn' value="assignTeacher"> Nommer Formateur</option>
						</select>
					</td>
					<td>
						<button><input type="submit" value="Confirmer" class="btn"></button>
					</td>
				</form>	
			</tr>
		<?php
		}
			elseif($user["status"] == 4){?>
				<form method="POST" action="adminPanel.php?user=<?php echo $user["id"]?>">
					<td>
						<select name="actions" class="select">
							<option class='btn' value="delUser">Supprimer</option>
							<option class='btn' value="banUSer">Bannir</option>
							<option class='btn' value="assignMod">Nommer Modérateur</option>
							<option class='btn' value="assignUser">Déstituer Administrateur</option>
							<option class='btn' value="assignTeacher"> Nommer Formateur</option>
						</select>
					</td>
					<td>
						<button><input type="submit" value="Confirmer" class="btn"></button>
					</td>
				</form>	
			</tr>	
<?php
}
		}
		?>

	</tbody>
</table>


<?php include "templates/footer.php"; ?>
