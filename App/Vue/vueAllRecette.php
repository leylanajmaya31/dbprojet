<?php ob_start() ?>
<h1 id="titreh1">TOUTES LES RECETTES</h1>
<hr>
<main class="mainContent">
        <?php foreach ($tab as $recette) : ?>
            <section class="card">
                <!-- ********************** Card 1 **********************  -->
                <div class="card1">
                    <img src="./Public/asset/images/<?= $recette['image_recette'] ?>" alt="...">
                    <h4><strong><?= $recette['nom_recette'] ?></strong></h4> <br>
                    <img src="./Public/asset/images/<?= $recette['image_auteur'] ?>" alt="..." class="profil">
                    <p>Publiée par: <?= $recette['nom_auteur'] ?> <?= $recette['prenom_auteur'] ?></p> <br>
                    <a href="./recetteone <?= $recette['id_recette'] ?>">
                    <button type="submit" id="cardButton">Lire la recette</button>
                    </a>
                </div>
            </section>
        <?php endforeach ?>
        <p><?= $error ?></p>
</main>
<?php $content = ob_get_clean() ?>


