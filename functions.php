<?php

/**
 * 
 * @return \mysqli
 */
function connectMySQL($create = false, $user = "aaht", $pwd = "gbDHeWMRHPW0Bon9b9MFoHFYO4ulh6Eqtg3JPZt010HNG-1hAV") {
    if (!$create) {
        //$mysqli = new mysqli("localhost", "root", "", "inf19b_aaht_flight");
        $mysqli = new mysqli("inf19b.feste-ip.net:15108", $user, $pwd, "inf19b_aaht_flight");
        //$mysqli = new mysqli("inf19b.ddns.net", $user, $pwd, "inf19b_aaht_flight");
    } else {
        //$mysqli = new mysqli("localhost", "root", "");
        $mysqli = new mysqli("inf19b.feste-ip.net:15108", $user, $pwd);
        //$mysqli = new mysqli("inf19b.ddns.net", $user, $pwd);
    }
    if (!$mysqli || $mysqli->errno > 0) {
        echo "<strong class=\"error\">Die Verbindung zum MySQL-Server konnte nicht hergestellt werden!</strong><br>\n";
        echo $mysqli->error ?? mysqli_connect_error();
        include("footer.php");
        exit();
    }
    $mysqli->query("set names utf8mb4"); //Set_charset funzt bei utf8mb4 nicht, es wird intern LATIN1 draus... Das der Workaround
    return $mysqli;
}

function get_picture_path($subDir){
    return "/HypertextPreprocessor/Resources/Layout/Pics/$subDir/";
}

function createDataBase($dbname) {
    $mysqli = connectMySQL(true, "root", "ZVANB)J{>8%FrNCC1LmpnFU?5Uq=%5J9G|98p(%}^<B^ClN2be");
    /** @var mysqli_result $query */
    $query = $mysqli->query("SHOW DATABASES LIKE '$dbname'");
    if ((!$query || $query->num_rows === 0) && $mysqli->query("CREATE DATABASE IF NOT EXISTS $dbname")) {
        $sqlfile = file_get_contents('Resources/inf19b_aaht_flight.sql');
        $mysqli = connectMySQL(false, "root", "ZVANB)J{>8%FrNCC1LmpnFU?5Uq=%5J9G|98p(%}^<B^ClN2be");
        $result = $mysqli->multi_query($sqlfile);
        if (!$result) {
            echo "<strong class=\"error\">Fehler beim Laden der MySQL-Eintr&auml;ge!</strong><br>\n";
            echo $mysqli->error ?? mysqli_connect_error();
            include("footer.php");
            exit();
        }
    } else {
        echo $mysqli->error;
    }
}

function setTitle($title) {
    global $pageTitle;
    $pageTitle = $title;
}

function checkInput(mysqli $mysqli, $email, $user) {
    return ($mysqli->query("SELECT * "
                    . "FROM account "
                    . "WHERE username = \"$user\" "
                    . "OR email = \"$email\""))->num_rows == 0;
}

function checkUser(mysqli $mysqli, $user) {
    return ($mysqli->query("SELECT * "
                    . "FROM account "
                    . "WHERE username = '$user'"))->num_rows > 0;
}

function checkPasswords($pw1, $pw2) {
    return $pw1 === $pw2;
}

function checkMail($email) {
    return strpos($email, '@') !== false && strpos($email, '.') !== false && strlen($email) >= 5; //nur nötig wenn input type=email nicht vom Browser unterstützt wird.
}

function checkUsername($username) {
    return strlen($username) >= 5;
}

function checkIBAN($iban) {
    $ibanLower = strtolower(str_replace(' ', '', $iban));
    $Countries = array('al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16, 'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28, 'cz' => 24, 'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18, 'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18, 'gt' => 28, 'hu' => 28, 'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27, 'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21, 'lt' => 20, 'lu' => 20, 'mk' => 19, 'mt' => 31, 'mr' => 27, 'mu' => 30, 'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24, 'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29, 'ro' => 24, 'sm' => 27, 'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24, 'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24);
    $Chars = array('a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35);

    if (array_key_exists(substr($ibanLower, 0, 2), $Countries) && strlen($ibanLower) == $Countries[substr($ibanLower, 0, 2)]) {

        $MovedChar = substr($ibanLower, 4) . substr($ibanLower, 0, 4);
        $MovedCharArray = str_split($MovedChar);
        $NewString = "";

        foreach ($MovedCharArray AS $key => $value) {
            if (!is_numeric($MovedCharArray[$key])) {
                $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
            }
            $NewString .= $MovedCharArray[$key];
        }

        if (bcmod($NewString, '97') == 1) {
            return true;
        }
    }
    return false;
}

function convertDate($datestring) {
    return date("d.m.Y", strtotime($datestring));
}

/**
 * @param String $errormessage
 * @param int $errortype
 * @param url $link
 * 
 * Displays an error screen, that links back to the given link
 */
function showerror($errormessage, $errortype, $link) {
    switch ($errortype) {
        case 0:
            $imgpath = get_picture_path("error")."info.svg";
            break;
        case 1:
            $imgpath = get_picture_path("error")."warning.svg";
            break;
        case 2:
            $imgpath = get_picture_path("error")."sad.svg";
            break;
    }

    echo
    "<div class=\"errorbgblur\">
        <div class=\"errorbox\">
            <div class=\"errorimage\">
                <img src=\"$imgpath\" alt=\"Fehlermeldungsbild\">
            </div>
        <div class=\"errortext\">
        $errormessage
        </div>
        <button class=\"errorok\" type=\"button\" onclick=\"location.href='$link'\">Hab ich was kaputt gemacht? ;-;</button>
        </div>
    </div>";

    include("footer.php");
    exit();
}

function get_min_max($mysqli, $field, $dbtablename) {
    $query = $mysqli->query("
            SELECT min($field) FROM $dbtablename
        ");

    $row = $query->fetch_row();
    $array["min"] = $row[0];
    $query->free();

    $query = $mysqli->query("
            SELECT max($field) FROM $dbtablename
        ");

    $row = $query->fetch_row();
    $array["max"] = $row[0];
    $query->free();

    return $array;
}

function get_all_possible_values($mysqli, $field, $dbtablename) {
    $query = $mysqli->query("
            SELECT $field FROM $dbtablename GROUP BY $field
        ");

    while ($value = $query->fetch_array(MYSQLI_NUM)) {
        $array[] = $value[0];
    }
    
    $query->free();
    return $array;
}

function isCurrentAdmin() {
    $issignedin = $_SESSION["login"] ?? FALSE;
    $roleID = $_SESSION["RoleID"] ?? 0;

    return ($issignedin && $roleID == 3);
}

function get_name_for_manufacturer($mysqli, $manufacturer_id) {
    $query = $mysqli->query("
            SELECT name FROM plane_manufacturer WHERE manufacturer_id = $manufacturer_id
        ");

    $result = $query->fetch_array(MYSQLI_NUM)[0];
    $query->free();

    return $result;
}

function get_ticket_price($mysqli, $flight_id){
    $query = $mysqli->query("
        SELECT price FROM flight WHERE flight_id = $flight_id
    ");

    return $query->fetch_array(MYSQLI_NUM)[0];
  }

function get_flight_string($mysqli, $flight_id){
    $query = $mysqli->query("
        SELECT * FROM flightview WHERE flight_id = $flight_id
    ");

    $result = $query->fetch_array(MYSQLI_ASSOC);

    return $result["airline_name"].": ".$result["departure_airport_code"]."-".$result["destination_airport_code"]." (".convertDate($result["departure_date"]).")";
}

function get_airline_picture_height(){
    return "150px";
}
function get_plane_picture_height(){
    return "300px";
}
function get_manufacturer_picture_height(){
    return "300px";
}

include("DataView/functions/functions_list.php");
include("DataView/functions/functions_detail.php");
include("DataView/functions/functions_changes.php");