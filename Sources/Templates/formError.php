<?php 
if(isset($_SESSION['errors'])) {
	$listOfErrors = unserialize($_SESSION['errors']);
	echo '<div class="alert alert-danger" role="alert">';
	foreach( $listOfErrors as $error){
			echo "<li>".$error;
	}
	echo "</div>";
	unset($_SESSION['errors']);
}
?>