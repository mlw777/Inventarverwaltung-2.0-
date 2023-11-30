<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fügen Sie die Bootstrap-CDN-Links hinzu -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <style>
 

    body {
        font-family: 'Segoe UI Light', sans-serif;
        background-color: #F0F0F0; /* Hintergrundfarbe */
        margin: 0;
        padding-bottom: 100px;
        
}
    

    /* Navbar-Stil */
    .navbar {
        background-color: #FFFFFF; /* Weiß */
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Schatten */
        margin-bottom: 0px;
        position: fixed;
        z-index: 2;
        width: 100%;
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 24px;
        color: #B22222; /* Rot */
    }

    /* Menüpunkt-Stil */
    .navbar-nav .nav-link {
        font-weight: bold;
        color: #333; /* Dunkelgrau */
        font-size: 14pt;
    }

    .navbar-nav .nav-link:hover {
        color: #e60000; /* Rot bei Hover */
    }

    /* Submenü-Stil */
    .sub-menu {
        background-color: #FFFFFF; /* Weiß */
        border-radius: 0 0 5px 5px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.1); /* Schatten */
    }

    .sub-menu a {
        color: #333; /* Dunkelgrau */
        font-size: 12pt;
    }

    .sub-menu a:hover {
        color: #e60000; /* Rot bei Hover */
    }

    /* Verbesserter Stil für das Hauptmenü und die Untermenüs */
    .navbar-nav .nav-item {
        position: relative;
    }

    .navbar-nav .nav-item:hover .sub-menu {
        display: block;
    }

    .sub-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1;
    }

    .sub-menu li {
        padding: 8px 16px;
    }


h1 {
    margin-top: 100px !important;
    text-align: center;
}
h2 {
    margin-top: 100px !important;
    
}

</style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="logo.png" alt="Ihr Logo" width="150"></a> <!-- Logo anpassen -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Startseite</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Inventar
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
                        <li><a class="dropdown-item" href="inventar.php">Inventarliste</a></li>
                        <li><a class="dropdown-item" href="inventar_neu.php">Inventar hinzufügen</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Teilnehmer
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                        <li><a class="dropdown-item" href="teilnehmer.php">Teilnehmerliste</a></li>
                        <li><a class="dropdown-item" href="teilnehmer_neu.php">Teilnehmer hinzufügen</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mitarbeiter
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink3">
                        <li><a class="dropdown-item" href="mitarbeiter.php">Mitarbeiterliste</a></li>
                        <li><a class="dropdown-item" href="mitarbeiter_neu.php">Mitarbeiter hinzufügen</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ausleihe.php">Ausleihe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rueckgabe.php">Rückgabe</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php include('abmelden_menu.php'); ?>
</body>
</html>
