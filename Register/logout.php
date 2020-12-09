<?php
/**
 * File: logoout.php
 * Author: Andreas Koehler
 * Description: Zerstoert die Session und melden den Benutzer so ab
 */
include('../header.php');

$signedIn = $_SESSION["login"] ?? false;

if ($signedIn) {
    $_SESSION["login"] = false;
    session_destroy();
}
echo "<meta http-equiv=\"refresh\" content=\"0; URL=../index.php\">";
include('../footer.php');
