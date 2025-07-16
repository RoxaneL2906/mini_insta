<?php
function lire_dossierPhotos()
{
    $file_names = [];
    try {
        $photos_dir = opendir("photos");

        do {
            $file_name = readdir($photos_dir);
            if ($file_name && $file_name != "." && $file_name != ".." && $file_name != "/") {
                $file_names[] = $file_name;
            }
        } while ($file_name);
    } catch (\Throwable $th) {
        throw $th;
    }
    rsort($file_names);
    return $file_names;
}

$liste_des_fichiers = lire_dossierPhotos();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini insta</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Libertinus+Mono&family=Mansalva&family=Meow+Script&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1>MINI INSTA</h1>
        <p>Ajoutez une photo !</p>


        <form class="boutons" action="/upload.php" method="post" enctype="multipart/form-data">
            <input class="emile" type="text" name="auteur" placeholder="Votre nom ici">

            <label id="nomImage" for="dl" class="clic"> Parcourir…</label>
            <input id="dl" type="file" name="photo" accept="image/*" onchange="document.getElementById('nomImage').innerHTML = this.value.split('\\').pop()">
            <!-- Pour supprimer C:\fakepath\ au début des noms de photos : 
            split('\\') découpe le chemin à chaque \, il faut 2 \ pour qu'il ne soit pas considéré comme un caractère spécial
            pop() récupère le dernier élément du nom découpé -->

            <label for="send" class="clic">Envoyer</label>
            <input id="send" type="submit" value="Envoyer">
        </form>

    </header>
    <main>
        <?php foreach ($liste_des_fichiers as $file_name): ?>
            <div class="image">
                <!-- Découpe le nom du fichier aux - et récupère la deuxième partie -->
                <?php $auteur = explode("-", $file_name)[1]; ?>
                <h2> <?php echo $auteur; ?></h2>
                <img src="<?php echo "photos/$file_name"; ?>" alt="Photo" />
                <p> <?php echo $file_name; ?> </p>
            </div>
        <?php endforeach; ?>
    </main>

</body>

</html>