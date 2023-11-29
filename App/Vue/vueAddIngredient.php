<?php ob_start()?>
    <!-- <form action="" method="post">
    <label for="quantite_ingredient">Nombre de personne ou portion</label>
        <input type="number" name="quantite_ingredient" id="quantite_ingredient" min="1" value="1">
        </div>
        <select name="portion_ingredient" id="portion_ingredient">
            <option value="personne">Personne</option>
            <option value="pièce">Pièce</option>
            <option value="portion">Portion</option>
            <option value="biscuit">Biscuit</option>
        </select>
    <label for="nom_ingredient"> Ingredient </label>
    <textarea id="nom_ingredient" name="nom_ingredient" placeholder="Saisir un ingrédient par ligne" rows="12" cols="35"></textarea>
        <input type="submit" value="Ajouter" name="submit">
    </form> -->
    <p><?=$error?></p>
<?php $content = ob_get_clean()?>



