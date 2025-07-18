<?php
// Condition pour delete une photo si un POST a été fait
// A mettre tout en haut avant le chargement des photos sinon il faut recharger la page
if (isset($_POST["delete"])) {
    // Récupération du nom de fichier à supprimer
    $file = $_POST['delete'];
    $filePath = 'photos/' . $file;

    if (file_exists($filePath)) {
        // Suppression du fichier et affichage d'un message d'erreur si ça rate
        if (!unlink($filePath)) {
            echo "Erreur lors de la suppression de l'image.";
        }
    } else {
        echo "Fichier introuvable.";
    }
}

// Variable $nomDossier pour pouvoir récupérer les photos de plusieurs dossiers
function lire_dossierPhotos($nomDossier)
{
    $file_names = [];
    try {
        // Ouverture du dossier
        $photos_dir = opendir($nomDossier);

        // boucle de lecture des fichiers du dossier, un nouveau fichier à chaque passage
        do {
            // fichier trouvé dans le dossier
            $file_name = readdir($photos_dir);
            // condition pour ne pas prendre en compte les dossiers cachés créés par défaut 
            if ($file_name && $file_name != "." && $file_name != ".." && $file_name != "/") {
                $file_names[] = $file_name;
            }
        } while ($file_name);
    } catch (\Throwable $th) {
        // affichage d'une erreur si le code dans "try" fait une erreur
        throw $th;
    }
    // tri du tableau par ordre alphabétique inversé (ici car les dates sont inversées)
    rsort($file_names);

    // création d'un objet pour associer les noms de dossier avec les noms des photos pour utiliser dans la balise img dans le html
    $objet = [];
    $objet["nomDossier"] = $nomDossier;
    $objet["listeNomsPhotos"] = $file_names;

    return $objet;
}

// Récupère le dossier des photos utilisateurs, vide par défaut
$photosUtilisateurs = lire_dossierPhotos("photos");
// Récupère le dossier des photos fixes de la page d'accueil
$photosAccueil = lire_dossierPhotos("imagesPageAccueil");
// tableau qui contient les différents dossiers de photos
$liste_des_dossiers = array($photosUtilisateurs, $photosAccueil);

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
        <!-- Boucle pour chaque objet du tableau comme dossier individuel -->
        <?php foreach ($liste_des_dossiers as $dossier): ?>
            <!-- Boucle pour chaque photo du dossier individuel -->
            <?php foreach ($dossier["listeNomsPhotos"] as $file_name): ?>
                <div class="post">
                    <!-- Découpe le nom du fichier aux - et récupère la deuxième partie -->
                    <?php $auteur = explode("-", $file_name)[1]; ?>
                    <h2> <?php echo $auteur; ?></h2>
                    <a href="<?php echo $dossier["nomDossier"] . "/" . $file_name; ?>">
                        <img src="<?php echo $dossier["nomDossier"] . "/" . $file_name; ?>" alt="Photo" />
                        <div class="photo-hover">Voir la photo</div>
                    </a>
                    <div class="underPhoto">
                        <p> <?php echo $file_name; ?> </p>

                        <!-- Condition qui n'affiche la corbeille que pour les photos qui ne sont pas dans imagesPageAccueil -->
                        <?php if ($dossier["nomDossier"] != "imagesPageAccueil"): ?>
                            <form class="deleteForm" action="/index.php" method="post">
                                <!-- input masqué qui contient le nom du fichier à supprimer -->
                                <input class="deletePost" type="text" name="delete" value="<?php echo $file_name; ?>">
                                <!-- Bouton pour supprimer une photo -->
                                <label class="deleteLabel" for="delete"><img src="corbeille.png" alt="" /></label>
                                <input class="deleteBouton" id="delete" type="submit" value="Supprimer">
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </main>
    <a class="up" href="#"><img src="fleche_haut.png"></a>
</body>

</html>