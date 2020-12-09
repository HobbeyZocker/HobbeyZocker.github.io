<?php
/**
 * File: forgotpassword.php
 * Author: Andreas Koehler
 * Description: Hierüber kann das Passwort eines Benutzers zurueckgesetzt werden. Dazu benoetigt er seinen Usernamen + E-Mail. An die Mail wird dann das PW verschickt.
 */
include('../header.php');
if (isset($_SESSION["login"]) && $_SESSION["login"]) {
    echo "<meta http-equiv=\"refresh\" content=\"0; URL=../index.php\">";
}
?>
<div class="login">
    <img src="/HypertextPreprocessor/Resources/Layout/Pics/profile.svg" class="login" alt="User-Logo">
    <h1 class="login">PASSWORT VERGESSEN</h1> 
    <form method="POST" enctype="multipart/form-data" name="forgottenForm" accept-charset="UTF-8"> 
        <input class="login" type="text" name="txtUser" value="" required placeholder="Nutzername" autocomplete="username" autofocus/>
        <input class="hidden" type="password" hidden autocomplete="current-password"/>
        <input class="login" type="email" name="txtEmail" value="" placeholder="E-Mail" autocomplete="email"/>

        <button class="login" id="button1" type="submit" name="submitForgotPW">Weiter</button>
        <button class="login" id="button2" type="button" onclick="window.location.href = 'register.php';">Registrieren</button> <br>
        <button class="login" id="button3" type="button" onclick="window.location.href = 'login.php';">Zur&uuml;ck zum Login</button>
    </form>
</div>

<?php
if (filter_input(INPUT_POST, "submitForgotPW") == "") {
    $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_EMAIL);
    $user = filter_input(INPUT_POST, "txtUser", FILTER_SANITIZE_STRING);
    $mysqli = connectMySQL();
    /** @var mysqli_result $result */
    $result = $mysqli->query("SELECT * "
            . "FROM account "
            . "WHERE username = '$user' and email = '$email'");
    if (!$result) {
        echo "<strong class=\"error\">Fehler beim Zugriff auf die Datenbank!</strong>";
        echo $mysqli->error;
    } else if ($result->num_rows == 0) {
        echo "<strong class=\"error\">Benutzer existiert in Kombination mit der E-Mail nicht!</strong>";
    } else {
        $pwd = bin2hex(openssl_random_pseudo_bytes(8));
        $result = $mysqli->query("UPDATE account "
                . "SET password = '" . hash("sha512", $pwd) . "' "
                . "WHERE username = '$user'");
        if (!$result) {
            echo "<strong class=\"error\">Fehler beim Zugriff auf die Datenbank!</strong>";
            echo $mysqli->error;
            $mysqli->rollback();
        } else {
            $receiver = $email;
            $title = "Neues Passwort";
            $from = "From:INf19B Hypertext Preprocessor";
            $text = "Hallo $user,\r\n\r\n"
                    . "Dein neues Passwort lautet: $pwd\r\n"
                    . "Du kannst es in der Benutzerverwaltung ändern.\r\n\r\n\r\n"
                    . "Mit freundlichen Grüßen\r\n\r\n"
                    . "Dein HypertextPreprocessor Team";

            $succ = mail($receiver, $title, $text, $from);
            if ($succ) {
                echo "<strong class=\"success\">E-Mail mit dem neuen Passwort wurde versandt!</strong>";
                $mysqli->commit();
            } else {
                echo "<strong class=\"error\">Fehler beim Senden der E-Mail!</strong>";
                $mysqli->rollback();
            }
        }
    }
    $mysqli->close();
}

include('../footer.php');

