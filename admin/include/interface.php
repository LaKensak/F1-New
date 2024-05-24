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
    <title>Administration F1</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <?php
    // récupération du nom du fichier php appelant cela va permettre de charger l'interface correspondante : fichier html portant le même nom ou le fichier de même nom dans le dossier interface
    $file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
    if (file_exists("$file.js")) {
        echo "<script defer type='module' src='$file.js' ></script>";
    }
    if (isset($head)) {
        echo $head;
    }
    ?>
</head>
<body>
<div class="container-fluid d-flex flex-column p-0 h-100">
    <header>
        <?php require 'menu.html' ?>
    </header>

    <main>
        <h3 class='text-center'><?= $titreFonction??''?><h3>
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
</div>
</body>
</html>
