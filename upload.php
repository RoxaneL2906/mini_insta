<?php

// Crée une variable qui vérifie qu'une photo a été sélectionnée et n'est pas vide
$isPhoto = isset($_FILES['photo']) && $_FILES["photo"]["name"] != "";
// Créé une variable pour forcer l'auteur à mettre un nom
$isAuteurRempli = isset($_POST['auteur']) && $_POST['auteur'] != "";
// Crée une variable pour vérifier que l'upload s'est bien déroulé
$isSuccessful = false;

// On vérifie qu'il y a un nom d'auteur
if ($isAuteurRempli) {
    $auteur = $_POST['auteur'];

    if ($isPhoto) {
        date_default_timezone_set('Europe/Paris');
        $nommage = date("YmdHis") . "-" . $auteur . "-" . $_FILES["photo"]["name"];
        $tmpFile = $_FILES['photo']['tmp_name'];
        $dossierPhoto = "photos/" . $nommage;
        $isSuccessful = move_uploaded_file($tmpFile, $dossierPhoto);
    }
}


if (isset($_POST["retour"])) {
    header("Location: /index.php");
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Insta</title>
    <link rel="stylesheet" href="upload.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Libertinus+Mono&family=Mansalva&family=Meow+Script&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1>MINI INSTA</h1>
    </header>

    <main>
        <!-- Bloc 1 si l'upload a réussi -->
        <?php if ($isSuccessful == true) : ?>
            <h2>Upload réussi ! </h2>
            <div>
                <img src="<?php echo $dossierPhoto; ?>" alt="Photo sauvegardée" />
                <p> <?php echo $nommage; ?> </p>
            </div>
            <!-- Bloc 1 si l'upload n'a PAS réussi -->
        <?php else : ?>
            <h2> Echec de l'upload ! </h2>

            <!-- Bloc 2 pour afficher le bon message d'erreur -->
            <!-- Si pas de photo et pas de nom en priorité -->
            <?php if (!$isPhoto && !$isAuteurRempli): ?>
                <p>Fais un effort, tu n'as rien mis</p>

                <!-- Si pas de nom -->
            <?php elseif (!$isAuteurRempli): ?>
                <p>Nom manquant</p>

                <!-- Si pas de photo -->
            <?php elseif (!$isPhoto): ?>
                <p>Photo manquante</p>

                <!-- Fin du deuxième if -->
            <?php endif; ?>

            <!-- Fin du premier if -->
        <?php endif; ?>

        <!-- <a href="/index.php">Retour à l'accueil </a> -->
        <form action="/upload.php" method="post">
            <input class="bouton" type="submit" name="retour" value="Retour à l'accueil">
        </form>
    </main>
</body>

</html>