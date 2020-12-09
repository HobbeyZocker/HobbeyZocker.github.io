<?php
/**
 * File: register.php
 * Author: Andreas Koehler
 * Description: Ermöglicht es einem Benutzer, sich zu registrieren als Kundenkonto. Hierfuer gibt er seine Daten in die Form ein und sendet diese ab.
 */
include('../header.php');
if (isset($_SESSION["login"]) && $_SESSION["login"]) {
    echo "\t\t\t<meta http-equiv=\"refresh\" content=\"0; URL=../index.php\">";
}
?> 
<div class="login">
    <img src="/HypertextPreprocessor/Resources/Layout/Pics/profile.svg" class="login" alt="User-Logo">
    <h1 class="login">REGISTRIEREN</h1> 
    <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8"> 
        <input class="login" type="text" name="txtUser" value="<?php echo filter_input(INPUT_POST, "txtUser", FILTER_SANITIZE_STRING) ?? "" ?>" required minlength="5" maxlength="20" placeholder="Nutzername" autocomplete="username" autofocus/>
        <input class="login" type="password" name="txtPassword" value="" required minlength="8" placeholder="Passwort" autocomplete="new-password"/>
        <input class="login" type="password" name="txtPassword2" value="" required minlength="8" placeholder="Passwort wiederholen" autocomplete="new-password"/>
        <input class="login" type="email" name="txtEmail" value="<?php echo filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_EMAIL) ?? "" ?>" required maxlength="40" placeholder="E-Mail" autocomplete="email"/>
        <input class="login" type="text" name="txtFname" value="<?php echo filter_input(INPUT_POST, "txtFname", FILTER_SANITIZE_STRING) ?? "" ?>" required maxlength="20" placeholder="Vorname" autocomplete="given-name"/>
        <input class="login" type="text" name="txtLname" value="<?php echo filter_input(INPUT_POST, "txtLname", FILTER_SANITIZE_STRING) ?? "" ?>" required maxlength="20" placeholder="Nachname" autocomplete="family-name"/>
        <input class="login" type="text" name="txtStreet" value="<?php echo filter_input(INPUT_POST, "txtStreet", FILTER_SANITIZE_STRING) ?? "" ?>" required maxlength="40" placeholder="Stra&szlig;e" autocomplete="address-line1"/>
        <input class="login" type="text" name="txtHnr" value="<?php echo filter_input(INPUT_POST, "txtHnr", FILTER_SANITIZE_STRING) ?? "" ?>" required maxlength="5" placeholder="Hausnummer" autocomplete="address-line2"/>
        <input class="login" type="text" name="txtZip" value="<?php echo filter_input(INPUT_POST, "txtZip", FILTER_SANITIZE_STRING) ?? "" ?>" required maxlength="5" pattern="[0-9]{5}" placeholder="Postleitzahl" title="Nur Zahlen erlaubt!" autocomplete="postal-code"/>
        <input class="login" type="text" name="txtCity" value="<?php echo filter_input(INPUT_POST, "txtCity", FILTER_SANITIZE_STRING) ?? "" ?>" required maxlength="40" placeholder="Ort" autocomplete="address-level2"/>
        <input class="login" type="text" name="txtIBAN" value="" required maxlength="42" placeholder="IBAN" autocomplete="cc-number"/>
        <input id="agb" type="checkbox" required /><label for="agb">Ich habe die <a href="terms.php">AGB</a> und <a href="privacy_policy.php">Datenschutzerkl&auml;rung</a> gelesen und akzeptiere sie.</label>

        <button class="login" id="button1" type="submit">Registrieren</button>
        <button class="login" id="button2" type="button" onclick="window.location.href = 'login.php';">Zum Login</button> <br>
        <button class="login" id="button3" type="reset">Eingabe l&ouml;schen</button>
    </form>
</div>
<?php
if (filter_input(INPUT_POST, "txtUser", FILTER_SANITIZE_STRING) && filter_input(INPUT_POST, "txtPassword", FILTER_SANITIZE_STRING)) {
    $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, "txtUser", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "txtPassword", FILTER_SANITIZE_STRING);
    $password2 = filter_input(INPUT_POST, "txtPassword2", FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, "txtCity", FILTER_SANITIZE_STRING);
    $fName = filter_input(INPUT_POST, "txtFname", FILTER_SANITIZE_STRING);
    $lName = filter_input(INPUT_POST, "txtLname", FILTER_SANITIZE_STRING);
    $zip = filter_input(INPUT_POST, "txtZip", FILTER_SANITIZE_STRING);
    $street = filter_input(INPUT_POST, "txtStreet", FILTER_SANITIZE_STRING);
    $hNr = filter_input(INPUT_POST, "txtHnr", FILTER_SANITIZE_STRING);
    $iban = filter_input(INPUT_POST, "txtIBAN", FILTER_SANITIZE_STRING);

    $mysqli = connectMySQL();
    $registered = false;

    if (!checkPasswords($password, $password2)) {
        echo "<strong class=\"error\">Die Passw&ouml;rter sind nicht identisch!</strong>";
    } else if (!checkMail($email)) {
        echo "<strong class=\"error\">Die E-Mail ist nicht g&uuml;ltig!</strong>";
    } else if (!checkIBAN($iban)) {
        echo "<strong class=\"error\">Die IBAN ist nicht g&uuml;ltig!</strong>";
    } else if (checkInput($mysqli, $email, $username)) {
        try {
            $pass = hash("sha512", $password);
            /** @var mysqli_result $result */
            $result = $mysqli->query("INSERT INTO account "
                    . "VALUES ('$username', '$pass', '$email', 2, '$fName', '$lName', '$zip', '$city', '$street', '$hNr')");
            if (!$result) {
                echo "<strong class=\"error\">Fehler beim Schreiben in die Datenbank!</strong>";
                echo $mysqli->error;
                $mysqli->rollback();
            } else {
                $result = $mysqli->query("INSERT INTO payment_option "
                        . "VALUES (NULL, '$iban', '$username')");
                if (!$result) {
                    echo "<strong class=\"error\">Fehler beim Schreiben in die Datenbank!</strong>";
                    echo $mysqli->error;
                    $mysqli->rollback();
                } else {
                    $_SESSION["login"] = true;
                    $_SESSION["Username"] = $username;
                    $_SESSION["E-Mail"] = $email;
                    $_SESSION["Role"] = "Kunde";
                    $_SESSION["RoleID"] = 2;
                    $_SESSION["FName"] = $fName;
                    $_SESSION["LName"] = $lName;
                    $_SESSION["ZIP"] = $zip;
                    $_SESSION["City"] = $city;
                    $_SESSION["Street"] = $street;
                    $_SESSION["HNr"] = $hNr;
                    $_SESSION["IBAN"] = $iban;
                    $registered = true;
                    $mysqli->commit();
                }
            }
        } catch (EXCEPTION $e) {
            echo "<strong class=\"error\">Registrierung fehlgeschlagen!</strong>";
        }
    } else {
        echo "<strong class=\"error\">Benutzername oder E-Mail schon vorhanden!</strong>";
    }
    if ($registered) {
        echo "<meta http-equiv=\"refresh\" content=\"0; URL=../index.php\">";
    }

    $mysqli->close();
}
include('../footer.php');
