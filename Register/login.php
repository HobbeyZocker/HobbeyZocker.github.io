<?php
/**
 * File: login.php
 * Author: Andreas Koehler
 * Description: Seite, die alles Einlogtechnische beinhaltet. Dazu gehören Einloggen, Passwort prüfen und Weiterleitung zu PW vergessen + Registrieren
 */
include('../header.php');
if (isset($_SESSION["login"]) && $_SESSION["login"]) {
    echo "\t\t\t<meta http-equiv=\"refresh\" content=\"0; URL=../index.php\">";
}
?>
<div class="login">
    <img src="/HypertextPreprocessor/Resources/Layout/Pics/profile.svg" class="login" alt="User-Logo">
    <h1 class="login">LOGIN</h1> 
    <form method="POST" enctype="multipart/form-data" name="LoginForm" accept-charset="UTF-8"> 
        <input class="login" type="text" name="txtUser" value="" required placeholder="Nutzername" autocomplete="username" autofocus/>
        <input class="login" type="password" name="txtPassword" value="" required placeholder="Passwort" autocomplete="current-password"/>

        <button class="login" id="button1" type="submit">Einloggen</button>
        <button class="login" id="button2" type="button" onclick="window.location.href = 'register.php';">Registrieren</button> <br>
        <button class="login" id="button3" type="button" onclick="window.location.href = 'forgotpassword.php';">Passwort vergessen</button>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, "txtUser", FILTER_SANITIZE_STRING) && filter_input(INPUT_POST, "txtPassword", FILTER_SANITIZE_STRING)) {
    $username = filter_input(INPUT_POST, "txtUser", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "txtPassword", FILTER_SANITIZE_STRING);
    $signedIn = false;
    $mysqli = connectMySQL();
    if (checkUser($mysqli, $username)) {
        try {
            /** @var mysqli_result $result */
            $result = $mysqli->query(
                    "SELECT * "
                    . "FROM userdata "
                    . "WHERE username = \"$username\"");
            if (!$result) {
                echo "<strong class=\"error\">Fehler beim Zugriff auf die Datenbank!</strong>";
                echo $mysqli->error;
            } else {
                while (($row = $result->fetch_row()) && !$signedIn) {
                    $passwordHash = hash("sha512", $password);
                    if ($row[1] == $passwordHash) {
                        $_SESSION["login"] = true;
                        $_SESSION["Username"] = $row[0];
                        $_SESSION["E-Mail"] = $row[2];
                        $_SESSION["Role"] = $row[3];
                        $_SESSION["RoleID"] = $row[4];
                        $_SESSION["FName"] = $row[5];
                        $_SESSION["LName"] = $row[6];
                        $_SESSION["ZIP"] = $row[7];
                        $_SESSION["City"] = $row[8];
                        $_SESSION["Street"] = $row[9];
                        $_SESSION["HNr"] = $row[10];
                        $_SESSION["IBAN"] = $row[11];
                        $signedIn = true;
                    }
                }
                if (!$signedIn) {
                    echo "<strong class=\"error\">Passwort nicht korrekt!</strong>";
                }
            }
        } catch (EXCEPTION $e) {
            echo "<strong class=\"error\">Einloggen fehlgeschlagen!</strong>";
        }
    } else {
        echo "<strong class=\"error\">Benutzername nicht vorhanden!</strong>";
    }
    if ($signedIn) {
        echo "<meta http-equiv=\"refresh\" content=\"0; URL=../index.php\">";
    }
    $mysqli->close();
}

include('../footer.php');
