<?php
// si un lien de retour est renseigné, on le met en forme
if (isset($retour)) {
    $retour = <<<EOD
        <a href="$retour" class="my-auto" >
            <i title="retour au ménu général" class="btn btn-danger bi bi-arrow-90deg-up  p-2 border border-white rounded-circle"></i>
        </a>
EOD;
}
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Formation Web</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">

    <?php
    // récupération du nom du fichier php appelant cela va permettre de charger l'interface correspondante : fichier html portant le même nom ou le fichier de même nom dans le dossier interface
    $file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
    if (file_exists("$file.js")) {
        echo "<script defer type='module' src='$file.js' ></script>";
    } elseif (file_exists("js/$file.js")) {
        echo "<script defer type='module' src='js/$file.js' ></script>";
    }
    if (isset($head)) {
        echo $head;
    }
    ?>
    <script>
        window.addEventListener('load', miseEnFormePage, false);

        function miseEnFormePage() {
            // activation de toutes les popover et infobulle de la page
            document.querySelectorAll('[data-bs-toggle="popover"]').forEach(element => new bootstrap.Popover(element));
            // affichage de toutes les infobulles
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => new bootstrap.Tooltip(element));
            document.getElementById('pied').style.visibility = 'visible';
        }
    </script>
</head>
<body>
<div class="container-fluid d-flex flex-column p-0 h-100">
    <header>
        <div>Projet F1</div>
        <div class="my-auto"><?= $titreFonction ?? "" ?></div>
        <span id="actionTitre" class="mx-5 text-danger "><?= $retour ?? "" ?></span>
    </header>

    <main>
        <div class="my-1" id="msg"></div>
        <?php
        // l'interface peut être un fichier php lorsqu'elle inclut une partie commune à plusieurs interfaces : (ajout et modification par exemple)
        if (file_exists("$file.html")) {
            require "$file.html";
        } elseif (file_exists("interface/$file.html")) {
            require "interface/$file.html";
        } elseif (file_exists("interface/$file.php")) {
            require "interface/$file.php";
        }
        ?>
    </main>
    <footer id="pied">
        <div>© 2024 Moubarak</div>
    </footer>
</div>
</body>
</html>
