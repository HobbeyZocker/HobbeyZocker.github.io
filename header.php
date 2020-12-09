<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="DE">
    <head>
        <meta charset="utf-8">
        <meta name=“description“ content="Uni-Projekt f&uuml;r Web-Engineering zur Anzeige von Flugdaten und die Erm&ouml;glichung der Buchung dieser." />
        <meta name=”robots” content="noindex"/>
        <link rel="stylesheet" href="/HypertextPreprocessor/Resources/Layout/main.css">
        <link rel="icon" type="image/png" href="/HypertextPreprocessor/Resources/Layout/Pics/Logo/fdfd_favicon_256x.png">
        <title>---TITLE---</title>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        ini_set('default_charset', 'utf-8');

        include("functions.php");
        createDataBase("inf19b_aaht_flight");
        setTitle("Fl&uuml;ge");
        ?>

    </head> 
    <body> 
        <div class="page-wrap">
            <ul class="navbar">
                <li class="navbar"><a class="navbar" href="/HypertextPreprocessor/index.php">Startseite</a></li>
                <li class="navbar"><a class="navbar dropbtn" href="/HypertextPreprocessor/DataView/showflights.php">Flug&uuml;bersicht</a></li>
                        <!-- <div class="dropdown-content"> -->
                            <li class="navbar"><a class="navbar" href="/HypertextPreprocessor/DataView/showairlines.php">Fluggesellschaften</a></li>
                            <li class="navbar"><a class="navbar" href="/HypertextPreprocessor/DataView/showairports.php">Flugh&auml;fen</a></li>
                            <li class="navbar"><a class="navbar" href="/HypertextPreprocessor/DataView/showplanes.php">Flugzeuge</a></li>
                        <!-- </div> -->
                

                <?php
                if (isset($_SESSION["login"])) {
                    echo "<li class=\"navbar rechts\"><a class=\"navbar\" href=\"/HypertextPreprocessor/Register/logout.php\">Abmelden</a></li>\n"
                    . "\t\t\t\t\t<li class=\"navbar rechts\"><img src=\"/HypertextPreprocessor/Resources/Layout/Pics/profile.svg\" class=\"navbar\" alt=\"User-Logo\"></li>\n"
                    . "\t\t\t\t\t<li class=\"navbar rechts\"><label class=\"navbar\">" . $_SESSION['FName'] . " " . $_SESSION["LName"] . "</label></li>\n";
                } else {
                    echo "<li class=\"navbar rechts\"><a class=\"navbar\" href=\"/HypertextPreprocessor/Register/register.php\">Registrieren</a></li>
                          <li class=\"navbar rechts\"><a class=\"navbar\" href=\"/HypertextPreprocessor/Register/login.php\">Einloggen</a></li>\n";
                }
                ?>
            </ul>
