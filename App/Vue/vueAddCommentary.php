<?php ob_start()?>
    <form action="" method="post">
        <label for="commentaire_commenter">Laisser un commentaire</label>
        <textarea name="commentaire_commenter"cols="20" rows="5"></textarea>
        <input type="submit" value="Ajouter" name="submit">   
    </form>
    <p><?=$error?></p>
<?php $content = ob_get_clean()?>
