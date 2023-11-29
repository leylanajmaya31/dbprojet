<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un role</title>
    <script src="./Public/asset/script/script.js" async></script>
    <link rel="stylesheet" href="./Public/asset/style/style.css">
</head>
<body>
    <form action="" method="post">
        <label for="nom_role">Saisir le nom du role</label>
        <input type="text" name="nom_role">
        <input type="submit" value="Ajouter" name="submit">
    </form>
    <div><?=$error?></div>
</body>
</html>
