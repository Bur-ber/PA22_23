<?php 
session_start();
//vérifier les données entrées comme le cours et avec htmlentities
require('core/const.php');
require('core/functions.php');   
require('Templates/Header.php');

require('Templates/formError.php'); ?>


    <a href="/MasterTheWeb/Sources/forumIndex.php">Retour à l'accueil</a><br>
    
    <form action="actions/createPost.php" method="POST">
            <h1>Création d'un post</h1>
            <label for="title">Titre</label><br>
            <input type="text" name="title" id="title"><br>
            <div class="form-group">
            <label for="message">Contenu du message</label>
            <textarea name="message" class="form-control" id="message" rows="10"></textarea>
            </div>
            <button class="btn btn-primary" type='submit'>Créer mon post</button>
        </form>
      </body>
</html>
