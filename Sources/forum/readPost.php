<?php 
    $post = get_post($_GET['post']);
    $answers = get_answers($_GET['post']);
?>

    <h1><?= $post['title']; ?></h1>

    <?php require('Templates/formError.php'); ?>

    <a href="/MasterTheWeb/Sources/forumIndex.php">Retour à l'accueil</a>

        <table width="500">
        <thead>
        <tr>
                <th>
                    Auteur
                </th>
                <th>
                    Date
                </th>
                <th>
                    Messages
                </th>
            </tr>
        </thead>
        <tbody>
            <?php sscanf($post['created_at'], "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde); ?>
            <tr>
                <td><?= $post['mail'] ?></td>
                <td><?= $jour , '-' , $mois , '-' , $annee , ' ' , $heure , ':' , $minute ?></td>
                <td><?= $post['message'] ?></td>
            </tr>
        </tbody>
        </table>

        <?php if(count($answers) > 0){
        foreach($answers as $answer){ ?>

        
           
           <div class='card p-4 '>
            <?php if(is_answer_owner($answer['user_id'])) { ?>
                <a href="/edit.php">Editer le commentaire</a>
            <?php } ?>
                <p><?= $answer['author']; ?></p>
                <p><?= $answer['commented_at']?></p>
                <p><?= $answer['message']; ?></p>
           </div>

        <?php }}
        else { ?>
            Aucun commentaire sur ce post n'a été fait.
        <?php } ?>

        <form action="forum/answerPost.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $_GET['post']; ?>">
            <textarea name="comment" id="" cols="30" rows="10"></textarea>
            <button class="btn btn-primary" type='submit'>Envoyer mon commentaire</button>
        </form>

    </body>
</html>
