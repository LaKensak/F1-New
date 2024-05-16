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
    <title>F1 - GP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/f1_logo_red.svg"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.css"
          integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
        <nav class="bg-red-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="..">
                                <img class="w-20" src="/img/logo.svg" alt="Logo">
                            </a>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href=".."
                                   class="text-white hover:bg-white-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
                                <a href="/calendrier"
                                   class="text-white hover:bg-white-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Calendrier
                                    GP</a>
                                <a href="/classementpilote"
                                   class="text-white hover:bg-white-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Classement
                                    Pilotes</a>
                                <a href="/classementecurie"
                                   class="text-white hover:bg-white-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Classement
                                    Ecuries</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href=".."
                       class="text-white-300 hover:bg-white-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Accueil</a>

                    <a href="/calendrier"
                       class="text-white-300 hover:bg-white-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Calendrier
                        GP</a>

                    <a href="/classementpilote"
                       class="text-white-300 hover:bg-white-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Classement
                        Pilotes</a>

                    <a href="/classementecurie"
                       class="text-white-300 hover:bg-white-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Classement
                        Ecuries</a>
                </div>
            </div>
        </nav>

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
        <p>&copy L'Équipe des SLAM Saint-Remi</p>
        <ul>
            <li><a href="https://github.com/LaKensak" rel="author">Github</a></li>
        </ul>
    </footer>
</div>
</body>
</html>
