<?php
	session_start();
	require "core/const.php";
	require "core/functions.php";
	include "template/header.php";
	$statusRequired = 4;

	redirectIfNotConnected($statusRequired);
?>

<h1>Panel administrateur</h1>

<?php
	$connect = connectDB();
	$query = $connect -> query("SELECT * FROM " .PRE_DB. "USER");
	$listOfUsers = $query -> fetchAll();

?>

<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Genre</th>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Email</th>
			<th>Country</th>
			<th>Birthday</th>
			<th>Statut</th>
			<th>Ajout</th>
			<th>Modification</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>

		<?php
		foreach($listOfUsers as $user){
			echo "<tr>";
			echo "<td>".$user["id"]."</td>";
			echo "<td>".$user["gender"]."</td>";
			echo "<td>".$user["firstname"]."</td>";
			echo "<td>".$user["lastname"]."</td>";
			echo "<td>".$user["mail"]."</td>";
			echo "<td>".$user["country"]."</td>";
			echo "<td>".$user["birthday"]."</td>";
			echo "<td>".$user["status"]."</td>";
			echo "<td>".$user["created_at"]."</td>";
			echo "<td>".$user["updated_at"]."</td>";
			echo "<td><a class='btn btn-danger' href='core/delUsers.php?id=".$user["id"]."'>Supprimer</a></td>";
			echo "</tr>";
		}
		?>

	</tbody>
</table>


<?php include "template/footer.php"; ?>
