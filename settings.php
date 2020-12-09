<?php

/**
 * File: settings.php
 * Author: Andreas Koehler
 * Description: Dese beinhaltet die Moeglichkeit für den User, seine Benutzerdaten komfortabel anpassen zu koennen. 
 *              Hierfuer muss er sich mit seinem momentanen Passwort authentifizieren.
 */
include('header.php');
if (!isset($_SESSION["login"]) || $_SESSION["login"] == false) {
    echo "\t\t\t<meta http-equiv=\"refresh\" content=\"0; URL=Register/login.php\">";
}

if (isset($_SESSION["login"])) {
    if (filter_input(INPUT_POST, "back", FILTER_SANITIZE_STRING) || !filter_input_array(INPUT_POST) || filter_input(INPUT_POST, "sent")) {
        echo "\t\t\t<div>
                <form method=\"POST\" enctype=\"multipart/form-data\">
                            Benutzerdaten &auml;ndern:
                            <input type=submit name=\"settings\" value=\"Accounteinstellungen\">
                </form>
            </div>\n";
    } else if (filter_input(INPUT_POST, "settings")) {
        echo"\t\t\t<div>
                <form method=\"POST\" enctype=\"multipart/form-data\" accept-charset=\"UTF-8\">
                    Neues Passwort: 
                    <input type=password name=\"changePassword\" minlength=\"8\" autocomplete=\"new-password\">
                    <br>
                    Alte E-Mail: 
                    <label>" . $_SESSION["E-Mail"] . "</label>
                    <br>
                    Neue E-Mail: 
                    <input type=email name=\"changeEmail\" maxlength=\"40\" autocomplete=\"email\">
                    <br>
                    Alter Vorname: 
                    <label>" . $_SESSION["FName"] . "</label>
                    <br>
                    Neuer Vorname: 
                    <input type=text name=\"changeFname\" maxlength=\"20\" autocomplete=\"given-name\">
                    <br>
                    Alter Nachname: 
                    <label>" . $_SESSION["LName"] . "</label>
                    <br>
                    Neuer Nachname: 
                    <input type=text name=\"changeLname\" maxlength=\"20\" autocomplete=\"family-name\">
                    <br>
                    Momentane Adresse: 
                    <label>
                            " . $_SESSION["Street"] . " " . $_SESSION["HNr"] . ", " . $_SESSION["ZIP"] . " " . $_SESSION["City"] . "
                        </label>
                    <br>
                    Alte PLZ: 
                    <label>" . $_SESSION["ZIP"] . "</label>
                    <br>
                    Neue PLZ: 
                    <input type=text name=\"changeZip\" maxlength=\"5\" pattern=\"[0-9]{5}\" title=\"Nur Zahlen erlaubt!\" autocomplete=\"postal-code\">
                    <br>
                    Alte Stadt: 
                    <label>" . $_SESSION["City"] . "</label>
                    <br>
                    Neue Stadt: 
                    <input type=text name=\"changeCity\" maxlength=\"40\" autocomplete=\"address-level2\">
                    <br>
                    Alte Strasse: 
                    <label>" . $_SESSION["Street"] . "</label>
                    <br>
                    Neue Strasse: 
                    <input type=text name=\"changeStreet\" maxlength=\"40\" autocomplete=\"address-line1\">
                    <br>
                    Alte HNr: 
                    <label>" . $_SESSION["HNr"] . "</label>
                    <br>
                    Neue HNr: 
                    <input type=text name=\"changeHnr\" maxlength=\"5\" autocomplete=\"address-line2\">
                    <br>
                    Alte IBAN: 
                    <label>" . (isset($_SESSION["IBAN"]) ? $_SESSION["IBAN"] : "") . "</label>
                    <br>
                    Neue IBAN: 
                    <input type=text name=\"changeIban\" minLength=\"10\" maxlength=\"42\" autocomplete=\"cc-number\">

                    <br>
                    <input class=\"hidden\" type=\"text\" hidden autocomplete=\"username\"/>
                    <br>
                    Altes Passwort: 
                    <input type=password name=\"confirmPassword\" autocomplete=\"current-password\">
                    <br>
                    <input type=submit value=\"Zur&uuml;ck\" name=\"back\">
                    <input type=submit value=\"abschicken\" name=\"sent\">
                </form>
            </div>\n";
    }
    if (filter_input(INPUT_POST, "sent")) {
        $newPassword = filter_input(INPUT_POST, "changePassword", FILTER_SANITIZE_STRING);
        $newMail = filter_input(INPUT_POST, "changeEmail", FILTER_SANITIZE_EMAIL);
        $newZip = filter_input(INPUT_POST, "changeZip", FILTER_SANITIZE_STRING);
        $newCity = filter_input(INPUT_POST, "changeCity", FILTER_SANITIZE_STRING);
        $newStreet = filter_input(INPUT_POST, "changeStreet", FILTER_SANITIZE_STRING);
        $newHnr = filter_input(INPUT_POST, "changeHnr", FILTER_SANITIZE_STRING);
        $oldPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING);
        $newFname = filter_input(INPUT_POST, "changeFname", FILTER_SANITIZE_STRING);
        $newLname = filter_input(INPUT_POST, "changeLname", FILTER_SANITIZE_STRING);
        $newIBAN = filter_input(INPUT_POST, "changeIban", FILTER_SANITIZE_STRING);

        if ($newIBAN && !checkIBAN($newIBAN)) {
            echo "<strong class=\"error\">IBAN nicht valide!</strong>";
        } elseif (!checkMail($newMail)) {
            echo "<strong class=\"error\">E-Mail nicht korrekt!</strong>";
        } else {
            $mysqli = connectMySQL();
            try {
                /** @var mysqli_result $result */
                $result = $mysqli->query("SELECT * "
                        . "FROM userdata "
                        . "WHERE username = \"" . $_SESSION["Username"] . "\"");
                if (!$result) {
                    echo "<strong class=\"error\">Die Verbindung zum MySQL-Server konnte nicht hergestellt werden!</strong>";
                } else {
                    $row = $result->fetch_row();
                    $passwordHash = hash("sha512", $oldPassword);
                    if ($passwordHash !== $row[1]) {
                        echo "<strong class=\"error\">Altes PW falsch!</strong>";
                        $_POST["settings"] = true;
                    } else {
                        $newPassword = $newPassword === "" ? $row[1] : hash("sha512", $newPassword);
                        $_SESSION["E-Mail"] = $newMail = $newMail === "" ? $row[2] : $newMail;
                        $_SESSION["FName"] = $newFname = $newFname === "" ? $row[5] : $newFname;
                        $_SESSION["LName"] = $newLname = $newLname === "" ? $row[6] : $newLname;
                        $_SESSION["ZIP"] = $newZip = $newZip === "" ? $row[7] : $newZip;
                        $_SESSION["City"] = $newCity = $newCity === "" ? $row[8] : $newCity;
                        $_SESSION["Street"] = $newStreet = $newStreet === "" ? $row[9] : $newStreet;
                        $_SESSION["HNr"] = $newHnr = $newHnr === "" ? $row[10] : $newHnr;
                        $_SESSION["IBAN"] = $newIBAN = $newIBAN === "" ? $row[11] : $newIBAN;

                        $update = $mysqli->query("UPDATE account "
                                . "SET password='" . $newPassword
                                . "', email='" . $newMail
                                . "', first_name='" . $newFname
                                . "', last_name='" . $newLname
                                . "', postal_code='" . $newZip
                                . "', city='" . $newCity
                                . "', street='" . $newStreet
                                . "', street_number='" . $newHnr
                                . "', street='" . $newStreet
                                . "' WHERE username='" . $_SESSION['Username'] . "'");
                        if (!$update) {
                            echo "<strong class=\"error\">Fehler beim Schreiben in die Datenbank!</strong>";
                            echo $mysqli->error;
                        } else {
                            $update = $mysqli->query("UPDATE payment_option "
                                    . "SET iban='" . $newIBAN
                                    . "' WHERE uname = '" . $_SESSION['Username'] . "'");
                            if (!$update) {
                                echo "<strong class=\"error\">Fehler beim Schreiben in die Datenbank!</strong>";
                                echo $mysqli->error;
                            } else {
                                echo "<strong class=\"success\">Daten erfolgreich ge&auml;ndert!</strong>";
                            }
                        }
                    }
                }
            } catch (EXCEPTION $e) {
                
            }
            $_POST["settings"] = true;
            $mysqli->close();
        }
    }
}

include('footer.php');
