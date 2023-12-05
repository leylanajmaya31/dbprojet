<?php ob_start()?>
<form action="" method="post" id="form1" enctype="multipart/form-data">
    <label for="nom_recette"> Nom de la recette *</label>
    <input type="text" id="nom_recette" name="nom_recette">
    <label for="date_recette">Choisir la date</label>
    <input type="date" id="date_recette" name="date_recette">

    <div class="radio-container">
        <label for="niveau_recette"> Niveau de difficulté *</label>
        <div class="radio-group">
            <input type="radio" id="debutant" name="niveau_recette" value="debutant"> <label for="debutant"> Débutant</label>
            <input type="radio" id="intermediaire" name="niveau_recette" value="intermediaire"> <label for="intermediaire">Intermédiaire</label>
            <input type="radio" id="expert" name="niveau_recette" value="expert"> <label for="expert"> Expert</label>
        </div>
    </div>

    <div class="quantite-container">
        <label for="portion_recette">Nombre de personne ou portion</label>
        <input type="number" name="portion_recette" id="portion_recette" min="1" value="1">
        </div>
        <select name="unite_recette" id="unite_recette">
            <option value="personne">Personne</option>
            <option value="pièce">Pièce</option>
            <option value="portion">Portion</option>
            <option value="biscuit">Biscuit</option>
        </select>

        <label for="nom_ingredient">Ingrédient</label>
    <input type="text" id="nom_ingredient" name="nom_ingredient[]">

    <label for="quantite_ingredient">Quantité</label>
    <input type="number" id="quantite_ingredient" name="quantite_ingredient[]">

    <label for="unite_ingredient">Unité</label>
    <input type="text" id="unite_ingredient" name="unite_ingredient[]">
    <!-- <select id="unite_ingredient" name="unite_ingredient[]">
        <option value="kilogramme">kilogramme</option>
        <option value="gramme">gramme</option>
        <option value="centilitre">centilitre</option>
        <option value="millilitre">millilitre</option>
    </select> -->
    <button type="button" onclick="ajouterIngredient(event)">Ajouter un ingrédient</button>
    <!-- <ul id="ingredientList"></ul> -->
    <ul id="ingredientList" class="ingredient"></ul>



    <label for="description_recette"> Description de la recette *</label>
    <textarea id="description_recette" name="description_recette" placeholder="Ex: Faire fondre le chocolat" rows="12" cols="35"></textarea>

    <label for="temps_recette"> Temps de cuisson </label>
    <input type="time" id="temps_recette" name="temps_recette">

    <label for="image_recette">Télécharger une image</label>
    <input type="file" id="image_recette" name="image_recette">

    <button type="submit" name="submit"> SOUMETTRE LA RECETTE </button>
</form>
<p><?=$error?></p>
<?php $content = ob_get_clean()?>
