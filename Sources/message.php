 <?php
    session_start();
    require 'core/const.php';
    require 'core/functions.php';
    include 'templates/header.php';
    include 'templates/formError.php';
?>
    <h1>Messagerie</h1>
    <form  action="" method="POST">
        <textarea name="msg" id="msg" cols="30" rows="5"></textarea>
        <br>
        <input type="submit" name="send">

    </form>
    <section id="messages">

    </section>


<?php
    $errors=[];
    $getid = $_GET['id'];
    $getuser = get_receiver($getid);
    if(!isConnected()){
        header("Location:../login.php");
    }else{
        if(isset($getid) && !empty($getid)){
            if($getuser->rowCount() > 0){
                if(isset($_POST['send'])){
                        if($_POST['msg'] == ""){
                            $errors['msg'] = "Veuillez écrire avant un message avant d'envoyer";
                        }
                         if(!empty($errors)){
                            $_SESSION['errors'] = serialize($errors);
                        }
                        $message = htmlspecialchars($_POST['msg'], ENT_QUOTES);
                        send_message($message, $getid);
                        }   
            }else{
                $errors['message'] =  "Aucun utilisateur trouvé";
                $_SESSION['errors'] = serialize($errors);
            }
        }else{
            $errors['message'] =  "Aucun identifiant trouvé";
            $_SESSION['errors'] = serialize($errors);
        }     

}

$pseudo = get_pseudo($getid);
$messages = get_message($getid);
foreach ($messages as $index => $sentMessage){
     $sentAt = get_Time($sentMessage['sent_at']);
     if($sentMessage['receiver'] == $_SESSION['id']){
        ?>
        <p style="color:red"><?=  $pseudo[0]; ?></p>
        <p style="color:red"><?= $sentAt; ?></p>
        <p style="color:red"><?= $sentMessage['message']; ?></p>

        <?php
        }elseif($sentMessage['receiver'] == $getid){
            ?>
        <p style="color:green"><?= $_SESSION['pseudo']; ?></p>
        <p style="color:green"><?=  $sentMessage['sent_at']; ?></p>
        <p style="color:green"><?= $sentMessage['message']; ?></p>
        <?php
    }
        
}
?>

<a class="btn btn-light" href="mail.php">Retour en arrière</a>
<?php include 'templates/footer.php'; ?>
