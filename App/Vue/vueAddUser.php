<?php ob_start()?>
<form action="" method="post" enctype="multipart/form-data">
            <h4>INSCRIPTION</h4>
            <hr>
            <div class="name-field">
                <div>
                    <label>Nom</label>
                    <input type="text" name="nom_utilisateur" placeholder="Nom">
                </div>
                <div>
                    <label>Prénom</label>
                    <input type="text" name="prenom_utilisateur" placeholder="Prénom">
                </div>
            </div>
            <label>Adresse Mail</label>
            <input type="email" name="email_utilisateur" placeholder="E-mail">
            <label>Mot de passe</label>
            <input type="password" name='mdp_utilisateur' placeholder="Mot de passe">
            <input type="password" name='repeat_mdp_utilisateur' placeholder="Répetez mot de passe">
            <label for="image">Télécharger une image:</label>
            <input type="file" id="image" name="image_utilisateur" accept="image/png, image/jpeg" />
            <input type="submit" name='submit' value="S'inscrire">
            <div><?=$error?></div>
        </form>
<?php $content = ob_get_clean()?>

