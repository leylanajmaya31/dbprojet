<?php ob_start()?>
    <form action="" method="post">
        <label for="email_utilisateur">Saisir son email</label>
        <input type="email" name="email_utilisateur">
        <label for="mdp_utilisateur">Saisir son mot de passe</label>
        <input type="password" name="mdp_utilisateur">
        <input type="submit" value="Connexion" name="submit">
    </form>
    <?=$error?>
<?php $content = ob_get_clean()?>