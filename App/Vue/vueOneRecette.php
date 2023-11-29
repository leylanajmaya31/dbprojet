<?php ob_start() ?>
<h1 id="titreh1">DÉTAILS DE LA RECETTE</h1>
<hr>
<main class="mainContent">
    <section class="card">
        <!-- ********************** Card 1 **********************  -->
        <div class="card1">
            <img src="./Public/asset/images/<?= $recette->getImage() ?>" alt="...">
            <h4><strong>Titre: <?= $recette->getNom() ?></strong></h4> <br>
            <p>Publiée par: <?= $recette->getAuteur()->getNomUtilisateur() ?></p> <br>
            <p>Description: <?= $recette->getDescription() ?></p> <br>
            <!-- Ajoutez d'autres détails de la recette selon vos besoins -->
        </div>
    </section>
</main>
<?php $content = ob_get_clean() ?>






